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
import time
from sklearn.externals import joblib
import pyscreenshot as ImageGrab
import evdev
from pymouse import PyMouse
from pykeyboard import PyKeyboard

class LetsTryThis():
    def __init__(self):
        #Take in an image
        #Convert image to an list of numbers [,,,]
        pass

    def getImages(self, LocalDirectory, Pixels):
        arrayOfFiles = []
        for file in os.listdir(LocalDirectory):
            #print(file)
            img = Image.open(LocalDirectory+file)
            img = img.resize((Pixels,Pixels), Image.ANTIALIAS)
            arrayOfFiles.append(img)

        return  arrayOfFiles


    def ReshapeListOfImages(self, ImageFiles, Pixels):
        ReturnList = []
        for imagefile in ImageFiles:
            #imglist = list(imagefile.getdata())
            imageasfloat = skimage.img_as_float(imagefile)
            #china = imagefile

            image_array = np.reshape(imageasfloat, -1)


            #print(image_array)
            ReturnList.append(image_array)

        #print(ReturnList[0])

        return  ReturnList

    def ReshapeImage(self, ImageFile, Pixels):
            #imglist = list(imagefile.getdata())
        imageasfloat = skimage.img_as_float(ImageFile)
            #china = imagefile
        return imageasfloat


    def returnImage(self, pixels):
        img = Image.open('ApplesToOranges/Images/Apples/apple_1.jpeg')
        img = img.resize((pixels,pixels), Image.ANTIALIAS)
        return img
        #plt.imshow(img)
        #plt.show()

    def showImage(self, file):
        plt.imshow(file)
        plt.show()

    def SaveModel(self, clf, ModelName):
        joblib.dump(clf, ModelName)

if __name__ == '__main__':
    #Height - Offense Defense
    ImageSize = 500
    timeis = time.time()
    LTT = LetsTryThis()
    print("Starting Breakout AI Player")

    try :

        clf = joblib.load("BreakoutAI/BreakoutAI.pkl")
        print("Using Stored Classifier")


    except:
        print("Creating a new Classifier")
        #Instantiate the class.



        print("Grabbing Image files")
        #Grab apple pics.
        GameImageFiles = LTT.getImages("BreakoutAI/GameImages/", ImageSize)
        print("Image Count:"+ str(len(GameImageFiles)))

        print("Grabbing Keyboard tracker")
        #Loop and add label for apple pics
        KeyboardTrackerFile = open("BreakoutAI/KeyboardTracker.txt", 'r')
        labels = KeyboardTrackerFile.read().split("\n")



        ImageFilesAsFloats = LTT.ReshapeListOfImages(GameImageFiles[:], ImageSize)
        print("Lengths")
        print(len(ImageFilesAsFloats))
        print(len(labels))

        X_train, X_test, y_train, y_test = sklearn.cross_validation.train_test_split(ImageFilesAsFloats[:], labels[:], test_size=0.01)


        clf = tree.DecisionTreeClassifier()
        clf = clf.fit(X_train, y_train)

        joblib.dump(clf, "BreakoutAI/BreakoutAI.pkl")



    keepplaying = True

    kb = PyKeyboard()
    mouse = PyMouse()

    print("Press r when game is ready for AI to play")

    device = evdev.InputDevice("/dev/input/by-id/usb-Logitech_USB_Keyboard-event-kbd")
    for event in device.read_loop():
         if event.type == evdev.ecodes.EV_KEY:
             #print(evdev.categorize(event))
             #print(event.code)
             if event.code == 19:
                break

    timebewteenKeypresses = .1

    while keepplaying:
        #print(evdev.categorize(event))
        #print(event.code)r

        image = ImageGrab.grab(bbox=(550,350 ,1150, 900))
        img = image.resize((ImageSize, ImageSize), Image.ANTIALIAS)
        newimage = skimage.img_as_float(img)
        immagearray = np.reshape(newimage, -1)

        fakearray = []
        fakearray.append(immagearray)
        fakearray.append(immagearray)

        results = clf.predict(fakearray)
        realAnswer = results[0]

        print(results[0])

        if realAnswer == "Left":
            kb.press_key(kb.left_key)
            time.sleep(timebewteenKeypresses)
            kb.release_key(kb.left_key)

        if realAnswer == "Right":
            kb.press_key(kb.right_key)
            time.sleep(timebewteenKeypresses)
            kb.release_key(kb.right_key)

        if realAnswer == "Space":
            kb.press_key(kb.space)
            time.sleep(timebewteenKeypresses)
            kb.release_key(kb.space)





    #print(array[0])
    '''
    print("Apples:"+str(len(Applefiles)))
    for item in Applefiles:
        labels.append("Apple")

    #Grab organge pics
    Orangefiles = LTT.getImages("Images/Oranges/", ImageSize)
    #Loop and add label for apple pics
    print("Oranges:"+str(len(Orangefiles)))
    for item in Orangefiles:
        labels.append("Orange")

    AllFiles = Applefiles + Orangefiles

    #LTT.showImage(files[0])
    print("How many files do we have?:"+ str(len(labels)))


    listofpatches = LTT.ReshapeListOfImages(AllFiles[:], ImageSize)
    #listObject = LTT.IDk()
    print("How many images do we have?:"+ str(len(listofpatches)))


    #print(labels)

    X_train, X_test, y_train, y_test = sklearn.cross_validation.train_test_split(listofpatches[:], labels[:], test_size=0.1)

    print(time.time() - timeis)

    try :
        print("Using old classifier")
        clf = joblib.load('OrangeAndApplesClf.pkl')

        print("Testing for objects")
        print(y_test)
        print("Results are...")
        results = clf.predict(X_test)
        print results
        print(time.time() - timeis)

    except Exception, e:
        print("Creating new classifier")

        print(y_train)


        clf = tree.DecisionTreeClassifier()
        clf = clf.fit(X_train, y_train)
        joblib.dump(clf, "OrangeAndApplesClf.pkl")
        # Create a classifier: a support vector classifier
        #classifier = svm.SVC(gamma=0.001)
        # We learn the digits on the first half of the digits
        #classifier.fit(listofpatches, labels)
        #print("Hello:"+ str(len(X_t
        # print(type(X_test))

        #reshapedData = np.array(X_test, -1)


        #reshapedImage = LTT.ReshapeImage(file[-1], ImageSize)
        imagelist = []
        #imagelist.append(reshapedImage)
        listofrlabel = []
        listofrlabel.append(labels[-1])
        print("Testing for objects")
        print(y_test)
        print("Results are...")
        results = clf.predict(X_test)
        print results
        print(time.time() - timeis)

    '''
    '''
        for item, labelname, guess in zip(X_test, y_test, results):
            array21 = np.reshape(item, (ImageSize, ImageSize, 3))
            #print(array21)
            plt.imshow(array21)
            plt.title("Answer:" + labelname + " Guess:" + guess)

            plt.show()
    '''
    #array21 = np.reshape(X_test[0], (ImageSize, ImageSize, 3))
    #print(array21)
    #plt.imshow(array21)
    #plt.show()
    #LTT.showImage(files[-1])

