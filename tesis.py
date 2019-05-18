#notas al fondo
import mysql.connector
import cv2
import numpy as np
from datetime import datetime

mydb = mysql.connector.connect(host="localhost", user="root", passwd="", database="videoroom")
mycursor = mydb.cursor(buffered=True)

def new_video_writer(input1):

	mycursor.execute("SELECT * FROM control")
	juego_actual = mycursor.fetchone()[2]

	mycursor.execute("SELECT COUNT(*) FROM turnos WHERE id_calendario=" +
	                 str(juego_actual) + " LIMIT 1")
	numero_turnos = mycursor.fetchone()[0]

	inning_actual = 0
	if numero_turnos > 0:
		mycursor.execute("SELECT inning FROM turnos ORDER BY id DESC LIMIT 1")
		inning_actual = mycursor.fetchone()[0]

	mycursor.execute("SELECT * FROM jugador WHERE R32=1")
	
	jugadores = mycursor.fetchall()
	
	cap = cv2.VideoCapture(input1)

	codec = cv2.VideoWriter_fourcc(*"MP4V")
	length = cap.get(cv2.CAP_PROP_FRAME_COUNT)
	fps = cap.get(cv2.CAP_PROP_FPS)
	width = int(cap.get(3))
	height = int(cap.get(4))
	
	if cap.isOpened() == True:
		jugador_actual = []
		match = 0
		out = cv2.VideoWriter()
		index = 0
		current = 60
		finished = False
		ultimo_jugador = 0

		while True:
			ret, frame = cap.read()
			coincidencias = []
			if ret:
				index += 1
				
				for jugador in jugadores:
					try:
						match, img = video_feature_matching(jugador[7], frame)
						coincidencias.append([jugador[0], match, jugador[5], img])
					except Exception as e:
						print("exception0: " + str(e))
						coincidencias.append([jugador[0], 0, jugador[5], frame])

				mayor = 0
				for i in coincidencias:
					if i[1] > mayor:
						mayor = i[1]
						jugador_actual = i

				if jugador_actual[1] >= 20:

					if current >= 60 or ultimo_jugador != jugador_actual[0]:

						if numero_turnos < 1:
							inning_actual += 1

						else:
							mycursor.execute("SELECT posicion FROM turnos WHERE id_jugador=" + str(
								jugador_actual[0]) + " AND id_calendario=" + str(juego_actual) + " ORDER BY id DESC LIMIT 1")

							mycursor.execute("SELECT posicion FROM turnos WHERE id_calendario=" +
							                 str(juego_actual) + " ORDER BY id DESC LIMIT 1")
							ultimo_jugador_posicion = mycursor.fetchone()[0]

							if ultimo_jugador_posicion != "PT" and jugador_actual[2] == "PT":
								inning_actual += 1
						
						hora = datetime.now().strftime('%H:%M:%S')
						mycursor.execute("INSERT INTO turnos(id_calendario, id_jugador, posicion, inning, tiempo_inicio) VALUES(%s, %s, %s, %s, %s)", (juego_actual, jugador_actual[0], jugador_actual[2], inning_actual, hora))
						mydb.commit()
						numero_turnos += 1

						mycursor.execute("SELECT id_jugador FROM turnos WHERE id_calendario=" +
						                 str(juego_actual) + " ORDER BY id DESC LIMIT 1")
						ultimo_jugador = mycursor.fetchone()[0]

						out_name = 'out' + str(jugador_actual[0])+'-'+ str(numero_turnos) +'.mp4'
						out = cv2.VideoWriter('videos/videos/'+out_name, codec, fps, (width, height))
						finished = True

					current = 0
					out.write(frame)

				elif jugador_actual[1] < 20 and current < 60:
					current += 1
					out.write(frame)

				elif jugador_actual[1] < 20 and current >= 60:

					if finished == True:
						mycursor.execute("SELECT id FROM turnos WHERE id_calendario=" +
                                                    str(juego_actual) + " ORDER BY id DESC LIMIT 1")
						ultimo_turno = mycursor.fetchone()[0]

						mycursor.execute("INSERT INTO video(direccion, id_jugador, id_calendario, id_turno, camara) VALUES (%s, %s, %s, %s, %s)", ("videos/"+out_name, jugador_actual[0], juego_actual, ultimo_turno, 1))
						mydb.commit()
						finished = False
						out.release()

				cv2.imshow('Comparacion', jugador_actual[3])

				if cv2.waitKey(1) & 0xFF == 27:
					break

			else:
				break


		cap.release()
	else:
		print("error")

def video_feature_matching(base, frame):
	img1 = cv2.imread(base, 0)  # objeto base
	img2 = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)# frame a analizar

	# Iniciar ORB
	orb = cv2.ORB_create()

	# Encontrar los puntos claves
	kp1, des1 = orb.detectAndCompute(img1, None)
	kp2, des2 = orb.detectAndCompute(img2, None)

	# Parametros FLANN
	FLANN_INDEX_LSH = 6
	index_params = dict(algorithm=FLANN_INDEX_LSH, table_number=6, key_size=12, multi_probe_level=2)  # 2
	search_params = dict(checks=10)  # Numero de Chequeos

	# Iniciar FLANN
	flann = cv2.FlannBasedMatcher(index_params, search_params)

	matches = flann.knnMatch(des1, des2, k=2)
	good = []
	for m, n in matches:
		if m.distance < 0.75*n.distance:
			good.append(m)
	img3 = cv2.drawMatches(img1, kp1, img2, kp2, good, None, flags=2)
	
	return len(good), img3

def video_feature_matching1(base, frame):
	img1 = cv2.imread(base, 0)  # objeto base
	img2 = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)  # frame a analizar

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


new_video_writer('ejecutar/video_2019-04-16_20-30-37.mp4')


# para avi --> cv2.VideoWriter_fourcc(*"FMP4")
# para mp4 --> cv2.VideoWriter_fourcc(*"mp4v")
# para webm --> cv2.VideoWriter_fourcc(*"VP80")

#mostrar video
#image = cv2.resize(frame, (0, 0), None, .50, .50)
#image1 = cv2.resize(frame1, (0, 0), None, .25, .25)
#numpy_horizontal_concat = np.concatenate((image1, image), axis=1)
#cv2.imshow('Numpy Horizontal',image)
#cv2.waitKey(25) & 0xFF
