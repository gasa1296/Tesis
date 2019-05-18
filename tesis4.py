from multiprocessing import Process, Queue
import mysql.connector
import cv2
import numpy as np
from datetime import datetime


def run_camara(direccion, arreglo_jugadores, cola, indice_proceso_actual):
	cap = cv2.VideoCapture(direccion)

	jugador_actual = None
	continuar1 = True

	if cap.isOpened():

		while continuar1:
			coincidencias = []
			ret, frame = cap.read()

			if ret:
				for jugador in arreglo_jugadores:

					try:
						coincidencias.append([jugador[0], video_feature_matching1(frame, "img/jugadores/" + str(jugador[9])), jugador[7]])

					except Exception as e:
						print("exception0: " + str(e))
						coincidencias.append([jugador[0], 0, jugador[5]])

				mayor1 = 0
				for i in coincidencias:
					if i[1] > mayor1:
						mayor1 = i[1]
						jugador_actual = i

				cola.put([jugador_actual, continuar1, frame,
						  cap.get(cv2.CAP_PROP_FPS), int(cap.get(3)), int(cap.get(4))])
			elif cv2.waitKey(1) & 0xFF == 27:
				continuar1 = False
				break
			else:
				continuar1 = False
				break
		cap.release()

	else:
		print("error")

def video_feature_matching1(frame, base):
	img1 = cv2.imread(base, 0)  # objeto base
	img2 = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)  # .frame a analizar

	# Iniciar ORB
	orb = cv2.ORB_create()

	# Encontrar los puntos claves
	kp1, des1 = orb.detectAndCompute(img1, None)
	kp2, des2 = orb.detectAndCompute(img2, None)

	# Parametros FLANN
	FLANN_INDEX_LSH = 6
	index_params = dict(algorithm=FLANN_INDEX_LSH, table_number=6, key_size=12, multi_probe_level=2)  # 2
	search_params = dict(checks=1)  # Numero de Chequeos

	# Iniciar FLANN
	flann = cv2.FlannBasedMatcher(index_params, search_params)

	good = []
	for m, n in flann.knnMatch(des1, des2, k=2):
		if m.distance < 0.75*n.distance:
			good.append(m)

	return len(good)



if __name__ == '__main__':
	COLA1 = Queue()
	COLA2 = Queue()

	MYDB = mysql.connector.connect(host="localhost", user="root", passwd="", database="videoroom")
	MYCURSOR = MYDB.cursor(buffered=True)

	MYCURSOR.execute("SELECT * FROM jugador WHERE R32=1")
	JUGADORES = MYCURSOR.fetchall()

	CAMARA1 = Process(target=run_camara, args=('ejecutar/video_2019-04-16_20-30-37.mp4', JUGADORES, COLA1, 1))
	CAMARA2 = Process(target=run_camara, args=('ejecutar/video_2019-04-25_15-35-02.mp4', JUGADORES, COLA2, 2))

	CAMARA1.start()
	CAMARA2.start()

	indice_proceso = 0
	ult_jug = 0
	nro_cam = 0
	tolerancia = 60
	finished = False
	out_name = ""
	out = None
	codec = cv2.VideoWriter_fourcc(*"mp4v")

	MYCURSOR.execute("SELECT juego_actual FROM control")
	juego_actual = MYCURSOR.fetchone()[0]

	def seleccion_insercion_grabado(camara_secundaria, jugador_mayor):
		global ult_jug, nro_cam, tolerancia, finished, out, out_name, codec, nro_cam
		#cola.put([jugador_actual, continuar, frame, fps, width, height])
		if ult_jug != jugador_mayor[0] or tolerancia >= 60:

			if ult_jug != jugador_mayor[0] and tolerancia < 60:
				
				MYCURSOR.execute("SELECT id FROM turnos WHERE id_calendario=" + str(juego_actual) + " ORDER BY id DESC LIMIT 1")
				ultimo_turno1 = MYCURSOR.fetchone()[0]

				MYCURSOR.execute("INSERT INTO video(direccion, id_turno, camara) VALUES (%s, %s, %s)", ("videos/" + out_name, ultimo_turno1, nro_cam))
				MYDB.commit()

				finished = False
				out.release()

			MYCURSOR.execute("SELECT COUNT(id), inning FROM turnos WHERE id_calendario=" +
							 str(juego_actual) + " ORDER BY id DESC LIMIT 1")
			datos_turnos_inning = MYCURSOR.fetchone()
			nro_turnos = datos_turnos_inning[0]

			if nro_turnos < 1:
				inning_actual = 1
			else:
				inning_actual = datos_turnos_inning[1]

				MYCURSOR.execute("SELECT posicion FROM turnos WHERE id_calendario=" +
								 str(juego_actual) + " ORDER BY id DESC LIMIT 1")
				ult_jug_pos = MYCURSOR.fetchone()[0]

				if ult_jug_pos != "PT" and jugador_mayor[2] == "PT":

					inning_actual += 1

			hora = datetime.now().strftime('%H:%M:%S')

			MYCURSOR.execute("INSERT INTO turnos(id_calendario, id_jugador, posicion, inning, tiempo_inicio) VALUES(%s, %s, %s, %s, %s)",
							 (juego_actual, jugador_mayor[0], jugador_mayor[2], inning_actual, hora))
			MYDB.commit()

			nro_turnos += 1

			ult_jug = jugador_mayor[0]

			out_name = 'out' + \
				str(jugador_mayor[0])+'-' + str(nro_turnos) + '.mp4'
			out = cv2.VideoWriter('videos/videos/' + out_name, codec, camara_secundaria[3], (camara_secundaria[4], camara_secundaria[5]))
			finished = True


	continuar = True
	while continuar:

		CAMARA1 = COLA1.get()
		CAMARA2 = COLA2.get()
		#cola.put([jugador_actual, continuar, frame, width, height])
		if CAMARA1[0] and CAMARA2[0] and CAMARA1[1] and CAMARA2[1]:
			if CAMARA1[0][1] > 15 and CAMARA1[0][1] > CAMARA2[0][1]:
				mayor = CAMARA1[0]
				seleccion_insercion_grabado(CAMARA2, mayor)
				nro_cam = 1
				tolerancia = 0
				out.write(CAMARA2[2])

			elif CAMARA2[0][1] > 15 and CAMARA2[0][1] > CAMARA1[0][1]:
				mayor = CAMARA2[0]
				seleccion_insercion_grabado(CAMARA1, mayor)
				nro_cam = 2
				tolerancia = 0
				out.write(CAMARA1[2])
				print(tolerancia)

			else:
				print(tolerancia)
				if tolerancia < 60:
					tolerancia += 1

					if nro_cam == 1:
						out.write(CAMARA2[2])

					else:
						out.write(CAMARA1[2])

				else:
					print(tolerancia)
					if finished:
						MYCURSOR.execute("SELECT id FROM turnos WHERE id_calendario=" + str(juego_actual) + " ORDER BY id DESC LIMIT 1")
						ultimo_turno = MYCURSOR.fetchone()[0]

						MYCURSOR.execute("INSERT INTO video(direccion, id_turno, camara) VALUES (%s, %s, %s)", ("videos/" + out_name, ultimo_turno, nro_cam))
						MYDB.commit()

						finished = False
						out.release()

		try:
			image = cv2.resize(CAMARA1[2], (0, 0), None, .75, .75)
			image1 = cv2.resize(CAMARA2[2], (0, 0), None, .75, .75)
			numpy_horizontal_concat = np.concatenate((image1, image), axis=1)
			cv2.imshow('video', numpy_horizontal_concat)
		except Exception as e:
			print("Excepcion de video: " + str(e))
		
		if cv2.waitKey(1) & 0xFF == 27:
			continuar = False
			break


# para avi --> cv2.VideoWriter_fourcc(*"FMP4")
# para mp4 --> cv2.VideoWriter_fourcc(*"mp4v")
# para webm --> cv2.VideoWriter_fourcc(*"VP80")
