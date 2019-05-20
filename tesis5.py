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

		while True:
			coincidencias = []
			ret, frame = cap.read()

			if ret:

				if indice_proceso_actual == 1 or indice_proceso_actual == 2:

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

					cola.put([jugador_actual, continuar1, frame, cap.get(cv2.CAP_PROP_FPS), int(cap.get(3)), int(cap.get(4)), indice_proceso_actual])

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

	MYDB = mysql.connector.connect(host="localhost", user="root", passwd="", database="videoroom")
	MYCURSOR = MYDB.cursor(buffered=True)

	MYCURSOR.execute("SELECT * FROM jugador WHERE R32=1")
	JUGADORES = MYCURSOR.fetchall()

	MYCURSOR.execute("SELECT id, direccion FROM camaras")
	CAMARAS = MYCURSOR.fetchall()

	PROCESOS = []
	COLAS = []

	for camara in CAMARAS:
		COLAS.append(Queue())
		PROCESOS.append(Process(target=run_camara, args=(str(camara[1]), JUGADORES, COLAS[len(COLAS)-1], camara[0])))

	for proceso in PROCESOS:
		proceso.start()

	max_toletancia = 0
	for cola in COLAS:
		max_toletancia += cola.put[3]

	max_toletancia = max_toletancia * 3/len(COLAS)

	MYCURSOR.execute("SELECT COUNT(id), inning FROM turnos WHERE id_calendario=" + str(juego_actual) + " ORDER BY id DESC LIMIT 1")
	datos_turnos_inning = MYCURSOR.fetchone()
	nro_turnos = datos_turnos_inning[0]

	if nro_turnos < 1:
		inning_actual = 1
	else:
		inning_actual = datos_turnos_inning[1]

	ult_jug = 0
	nro_cam = 0
	tolerancia = max_tolerancia
	finished = False
	out_name = ""
	out = None
	ultimo_turno = 0
	
	codec = cv2.VideoWriter_fourcc(*"VP80")

	MYCURSOR.execute("SELECT juego_actual FROM control")
	juego_actual = MYCURSOR.fetchone()[0]

	def seleccion_insercion_grabado(camara_secundaria, jugador_mayor):
		global ult_jug, nro_cam, tolerancia, finished, out, out_name, codec, max_toletancia, nro_turnos, inning_actual, ultimo_turno

		if ult_jug != jugador_mayor[0] or tolerancia >= max_tolerancia:

			if ult_jug != jugador_mayor[0] and tolerancia < max_tolerancia:
				MYCURSOR.execute("INSERT INTO video(direccion, id_turno, camara) VALUES (%s, %s, %s)", ("videos/" + out_name, ultimo_turno, nro_cam))
				MYDB.commit()

				finished = False
				out.release()

			MYCURSOR.execute("SELECT COUNT(id), inning FROM turnos WHERE id_calendario=" +
							 str(juego_actual) + " ORDER BY id DESC LIMIT 1")
			datos_turnos_inning = MYCURSOR.fetchone()
			nro_turnos = datos_turnos_inning[0]

			if nro_turnos > 0 and jugador_mayor[2] == "P":
				MYCURSOR.execute("SELECT posicion FROM turnos WHERE id_calendario=" + str(juego_actual) + " ORDER BY id DESC LIMIT 1")
				if MYCURSOR.fetchone()[0] != "P":
					inning_actual += 1

			hora = datetime.now().strftime('%H:%M:%S')

			MYCURSOR.execute("INSERT INTO turnos(id_calendario, id_jugador, posicion, inning, tiempo_inicio) VALUES(%s, %s, %s, %s, %s)",
							 (juego_actual, jugador_mayor[0], jugador_mayor[2], inning_actual, hora))
			MYDB.commit()

			ult_jug = cursor.lastrowid
			nro_turnos += 1
			finished = True

			out_name = str(ultimo_turno) + '.webm'
			out = cv2.VideoWriter('videos/videos/' + out_name, codec, camara_secundaria[3], (camara_secundaria[4], camara_secundaria[5]))

	while True:
		CAMARA1 = COLAS[0].get()
		CAMARA2 = COLAS[1].get()
		
		if CAMARA1[0] and CAMARA2[0] and CAMARA1[1] and CAMARA2[1]:

			if CAMARA1[0][1] > 15 and CAMARA1[0][1] > CAMARA2[0][1]:
				mayor = CAMARA1[0]
				nro_cam = CAMARA1[5]
				tolerancia = 0
				seleccion_insercion_grabado(CAMARA2, mayor)
				out.write(CAMARA2[2])

			elif CAMARA2[0][1] > 15 and CAMARA2[0][1] > CAMARA1[0][1]:
				mayor = CAMARA2[0]
				seleccion_insercion_grabado(CAMARA1, mayor)
				nro_cam = CAMARA2[5]
				tolerancia = 0
				out.write(CAMARA1[2])

			else:

				if tolerancia < max_tolerancia:
					tolerancia += 1

					if nro_cam == 1:
						out.write(CAMARA2[2])

					else:
						out.write(CAMARA1[2])

				else:

					if finished:
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

			for proceso in PROCESOS:
				proceso.terminate()
			break


# para avi --> cv2.VideoWriter_fourcc(*"FMP4")
# para mp4 --> cv2.VideoWriter_fourcc(*"mp4v")
# para webm --> cv2.VideoWriter_fourcc(*"VP80")
