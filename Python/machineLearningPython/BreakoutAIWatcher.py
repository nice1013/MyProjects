__author__ = 'root'

from sklearn import tree
from PIL import Image
import os
import numpy as np
import matplotlib.pyplot as plt
import matplotlib.image as mpimg
import os
from sklearn import datasets, svm, metrics
from sklearn.feature_extraction import image as sklearnimage
import skimage
import sklearn
import itertools
from matplotlib.widgets import Button
from sklearn.externals import joblib
from sklearn.cluster import MiniBatchKMeans
import random
#from PIL import ImageGrab
import pyscreenshot as ImageGrab
from threading import Thread
import time
from pymouse import PyMouse
from pykeyboard import PyKeyboard
import evdev
import collections

#BECOMING USELESS.
class MyNewKeyboardThread(Thread):


    def run(self):
        print("Keyboard Thread is starting.")
        #file = open("/dev/input/by-id/usb-Logitech_USB_Keyboard-event-kbd", 'rb')

        #Our Keyboard tracker file.


class MyNewMouseThread(Thread):

    maxValue = 255

    def run(self):
        print("Mouse Thread is starting.")
        mouse = open('/dev/input/mouse0')
        while True:
            status, dx, dy = tuple(ord(c) for c in mouse.read(3))

            #print("Mouse----")
            #print "%#02x %d %d" % (status, dx, dy)
            #print(dx, dy)

            #If dx is greater than half of the number it is going the other direction.
            if dx > 128:
                #print("Direction Left X")
                value=self.maxValue - dx
                #print(value)
            else:
                #print("Direction Right X")
                #print(dx)
                pass

            if dy > 128:
                #print("Direction Down X")
                value=self.maxValue - dy
                #print(value)
            else:
                pass
                #print("Direction Up X")sfw
                #print(dy)


class MoveMouse():
    def amount(self, x, y):
        mouse = PyMouse()
        xpos, ypos = mouse.position()

        mouse.move(xpos + x, ypos + y)




class InputListener():
    '''This game will run on this game at the is url.
            http://ataribreakout.net/atari-breakout-play

    '''



    ImagesAndCommands = []


    def __init__(self, KeyboardThread):
        self.KeyboardThread = KeyboardThread
        self.run()

    def InsertFeatureAndLabel(self, TrackerFile, Directory, KeyText):
        print(KeyText)
        self.ImagesAndCommands.append(KeyText)
        TrackerFile.write(KeyText+"\n")
        num = len(os.listdir("BreakoutAI/GameImages/"))
        image = ImageGrab.grab(bbox=(550,350 ,1150, 900))
        image.save(Directory+'im_'+str(num)+'.png')



    def run(self):
        print("Input Listener Thread has started.")

        #Our Keyboard Tracker
        DirKeyboardTrackerFile = "BreakoutAI/KeyboardTracker.txt"

        #Space between images.
        secondsToTakeImage = .1

        #Directory so we cant Create it.
        directory = "BreakoutAI/GameImages/"

        #Create the directory if it doesn't exist.
        if not os.path.exists(directory):
                os.makedirs(directory)

        #Grab input from the event file.
        device = evdev.InputDevice("/dev/input/by-id/usb-Logitech_USB_Keyboard-event-kbd")

        #Loop input coming from Input file.
        for event in device.read_loop():

            #Check for events.
            if event.type == evdev.ecodes.EV_KEY:
                 #print(evdev.categorize(event))
                 #print(event.code)
                 #If event is down key


                if event.value == 1:
                    try:
                        #Open Keyboard Tracker File.
                        KeyboardTrackerFile = open(DirKeyboardTrackerFile, 'a')

                        #Check to see if its any of the keys we want. (Left, Right, Spacebar.)
                        if event.code == 105:
                            #LEFT KEY
                            self.InsertFeatureAndLabel(KeyboardTrackerFile, directory, "Left")
                        if event.code == 106:
                            #RIGHT KEY
                            self.InsertFeatureAndLabel(KeyboardTrackerFile, directory, "Right")
                        if event.code == 57:
                            #SPACE BAR
                            self.InsertFeatureAndLabel(KeyboardTrackerFile, directory, "Space")

                        #Close Keyboard Tracker File.
                        KeyboardTrackerFile.close()

                    except:
                        pass

            #Time in between taking images
            time.sleep(secondsToTakeImage)




if __name__ == '__main__':
    #Height - Offense Defense
    ImageSize = 1
    labels = []

    DirKeyboardTrackerFile = "BreakoutAI/KeyboardTracker.txt"

    if not os.path.isfile(DirKeyboardTrackerFile):
        fileis = open(DirKeyboardTrackerFile, 'w+')
        fileis.close()

    print("Please Set Up Game. Press R when ready.")


    device = evdev.InputDevice("/dev/input/by-id/usb-Logitech_USB_Keyboard-event-kbd")
    for event in device.read_loop():
         if event.type == evdev.ecodes.EV_KEY:
             #print(evdev.categorize(event))
             #print(event.code)
             if event.code == 19:
                break



   #Starting the keyboard monitor thread.
    mnkbt = MyNewKeyboardThread()
    mnkbt.daemon = True
    mnkbt.start()

    #Starting the mouse monitor thread.
    mnmt = MyNewMouseThread()
    mnmt.daemon = True
    mnmt.start()

    MM = MoveMouse()
    MM.amount(1, 1)

    #Breakout AI:
    InputListenerthread = Thread(target=InputListener, args=(mnkbt,))
    InputListenerthread.daemon =  True
    InputListenerthread.start()

    mouse = PyMouse()
    keyboard = PyKeyboard()

    while(True):
        #keyboard.tap_key(keyboard.left_key)
        time.sleep(1)
    #image = ImageGrab.grab(bbox=(550,350 ,1150, 900))
    #image.show()


