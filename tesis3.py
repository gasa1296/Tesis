#notas al fondo
from threading import Thread
import mysql.connector
import cv2
import numpy as np
from datetime import datetime


class camara(Thread):

	def set(self, direccion, jugadores, indice_hilo):
		self.indice_hilo = indice_hilo
		self.indice_proceso = 0
		self.cap = cv2.VideoCapture(direccion)

		self.length = self.cap.get(cv2.CAP_PROP_FRAME_COUNT)
		self.fps = self.cap.get(cv2.CAP_PROP_FPS)
		self.width = int(self.cap.get(3))
		self.height = int(self.cap.get(4))

		self.jugadores = jugadores
		self.jugador_actual = None
		self.continuar = True
		self.frame = None

	def run(self):

		if self.cap.isOpened() == True:

			while self.continuar:

				coincidencias = []
				ret, self.frame = self.cap.read()

				if ret:
					print("ejecutando hilo " + str(self.indice_hilo))
					for jugador in self.jugadores:

						try:
							coincidencias.append(
								[jugador[0], self.video_feature_matching1(jugador[7]), jugador[5]])

						except Exception as e:
							print("exception0: " + str(e))
							coincidencias.append([jugador[0], 0, jugador[5]])

					mayor = 0
					for i in coincidencias:
						if i[1] > mayor:
							mayor = i[1]
							self.jugador_actual = i

				else:
					break

			self.cap.release()

		else:
			print("error")

	def video_feature_matching1(self, base):
		img1 = cv2.imread(base, 0)  # objeto base
		img2 = cv2.cvtColor(self.frame, cv2.COLOR_BGR2GRAY)  # self.frame a analizar

		# Iniciar ORB
		orb = cv2.ORB_create()

		# Encontrar los puntos claves
		kp1, des1 = orb.detectAndCompute(img1, None)
		kp2, des2 = orb.detectAndCompute(img2, None)

		# Parametros FLANN
		FLANN_INDEX_LSH = 6
		index_params = dict(algorithm=FLANN_INDEX_LSH, table_number=6,
                      key_size=12, multi_probe_level=2)  # 2
		search_params = dict(checks=10)  # Numero de Chequeos

		# Iniciar FLANN
		flann = cv2.FlannBasedMatcher(index_params, search_params)

		matches = flann.knnMatch(des1, des2, k=2)
		good = []
		for m, n in matches:
			if m.distance < 0.75*n.distance:
				good.append(m)

		return len(good)


class principal (Thread):

	def set(self):
		self.indice_proceso = 0
		self.ult_jug = 0
		self.nro_cam = 0
		self.tolerancia = 60
		self.finished = False
		self.out_name = ""
		self.out = None
		self.codec = cv2.VideoWriter_fourcc(*"mp4v")

		self.mydb = mysql.connector.connect(
			host="localhost", user="root", passwd="", database="videoroom")
		self.mycursor = self.mydb.cursor(buffered=True)

		self.mycursor.execute("SELECT juego_actual FROM control")
		self.juego_actual = self.mycursor.fetchone()[0]

		self.mycursor.execute("SELECT COUNT(id), inning FROM turnos WHERE id_calendario=" +
                        str(self.juego_actual) + " ORDER BY id DESC LIMIT 1")
		datos_turnos_inning = self.mycursor.fetchone()
		self.nro_turnos = datos_turnos_inning[0]

		if self.nro_turnos < 1:
			self.inning_actual = 1
		else:
			self.inning_actual = datos_turnos_inning[1]

	def seleccion_insercion_grabado(self, camara_principal, camara_secundaria, mayor):
		if self.ult_jug != camara_principal.jugador_actual[0] or self.tolerancia >= 60:

			if self.nro_turnos >= 1:

				self.mycursor.execute("SELECT posicion FROM turnos WHERE id_calendario=" +
                                    str(self.juego_actual) + " ORDER BY id DESC LIMIT 1")
				ult_jug_pos = self.mycursor.fetchone()[0]

				if ult_jug_pos != "PT" and mayor[2] == "PT":

					self.inning_actual += 1

			hora = datetime.now().strftime('%H:%M:%S')

			self.mycursor.execute("INSERT INTO turnos(id_calendario, id_jugador, posicion, inning, tiempo_inicio) VALUES(%s, %s, %s, %s, %s)",
                         (self.juego_actual, mayor[0], mayor[2], self.inning_actual, hora))
			self.mydb.commit()

			self.nro_turnos += 1

			self.ult_jug = mayor[0]

			self.out_name = 'out' + \
				str(mayor[0])+'-' + str(self.nro_turnos) + '.mp4'
			self.out = cv2.VideoWriter('videos/videos/' + self.out_name, self.codec,
                              camara_principal.fps, (camara_principal.width, camara_principal.height))
			self.finished = True

	def run(self):
		self.mycursor.execute("SELECT * FROM jugador WHERE R32=1")
		jugadores = self.mycursor.fetchall()

		camara1 = camara()
		camara1.set('ejecutar/video_2019-04-16_20-30-37.mp4', jugadores, 1)
		camara2 = camara()
		camara2.set('ejecutar/video_2019-04-25_15-35-02.mp4', jugadores, 2)

		camara1.start()
		camara2.start()
		while camara1.continuar and camara2.continuar:

			if camara1.jugador_actual and camara2.jugador_actual:
				print("ejacuntando principal")
				if camara1.jugador_actual[1] > 15 and camara1.jugador_actual[1] > camara2.jugador_actual[1]:
					mayor = camara1.jugador_actual
					self.seleccion_insercion_grabado(camara1, camara2, mayor)
					self.nro_cam = 1
					self.tolerancia = 0
					self.out.write(camara2.frame)

				elif camara2.jugador_actual[1] > 15 and camara2.jugador_actual[1] > camara1.jugador_actual[1]:
					mayor = camara2.jugador_actual
					self.seleccion_insercion_grabado(camara2, camara1, mayor)
					self.nro_cam = 2
					self.tolerancia = 0
					self.out.write(camara1.frame)

				else:
					if self.tolerancia < 60:
						self.tolerancia += 1

						if self.nro_cam == 1:
							self.out.write(camara2.frame)

						else:
							self.out.write(camara1.frame)

					else:
						if self.finished == True:
							self.mycursor.execute("SELECT id FROM turnos WHERE id_calendario=" +
                                                            str(self.juego_actual) + " ORDER BY id DESC LIMIT 1")
							ultimo_turno = self.mycursor.fetchone()[0]

							self.mycursor.execute("INSERT INTO video(direccion, id_jugador, id_calendario, id_turno, camara) VALUES (%s, %s, %s, %s, %s)",
                                                            ("videos/"+self.out_name, mayor[0], self.juego_actual, ultimo_turno, self.nro_cam))
							self.mydb.commit()

							self.finished = False
							self.out.release()

			try:
				image = cv2.resize(camara1.frame, (0, 0), None, .75, .75)
				image1 = cv2.resize(camara2.frame, (0, 0), None, .75, .75)
				numpy_horizontal_concat = np.concatenate((image1, image), axis=1)
				cv2.imshow('video', numpy_horizontal_concat)
			except Exception as e:
				print("Excepcion de video: " + str(e))
			
			if cv2.waitKey(1) & 0xFF == 27:
				camara1.continuar = False
				camara2.continuar = False
				break


# para avi --> cv2.VideoWriter_fourcc(*"FMP4")
# para mp4 --> cv2.VideoWriter_fourcc(*"mp4v")
# para webm --> cv2.VideoWriter_fourcc(*"VP80")

hilo_principal = principal()
hilo_principal.set()
hilo_principal.start()
hilo_principal.join()