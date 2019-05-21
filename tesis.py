#notas al fondo
import mysql.connector
import cv2
import numpy as np

def new_video_writer():
	
	cap = cv2.VideoCapture("../1.avi")
	cap1 = cv2.VideoCapture("../2.avi")
	
	if cap.isOpened() and cap1.isOpened():

		while True:
			ret, frame = cap.read()
			ret1, frame1 = cap1.read()
			if ret and ret1:

				image = cv2.resize(frame, (480, 360))
				image1 = cv2.resize(frame1, (480, 360))
				numpy_horizontal_concat = np.concatenate((image1, image), axis=1)

				cv2.imshow('Comparacion', numpy_horizontal_concat)

				if cv2.waitKey(1) & 0xFF == 27:
					break

			else:
				break


		cap.release()
	else:
		print("error")

new_video_writer()


# para avi --> cv2.VideoWriter_fourcc(*"FMP4")
# para mp4 --> cv2.VideoWriter_fourcc(*"mp4v")
# para webm --> cv2.VideoWriter_fourcc(*"VP80")

#mostrar video
#image = cv2.resize(frame, (0, 0), None, .50, .50)
#image1 = cv2.resize(frame1, (0, 0), None, .25, .25)
#numpy_horizontal_concat = np.concatenate((image1, image), axis=1)
#cv2.imshow('Numpy Horizontal',image)
#cv2.waitKey(25) & 0xFF
