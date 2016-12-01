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

    def addImagetoModule(self, clf, x_test, y_test):
        clf = clf.fit(x_test, y_test)
        joblib.dump(clf, 'filename.pkl')


if __name__ == '__main__':
    #Height - Offense Defense
    ImageSize = 1
    labels = []




    #Instantiate the class.
    LTT = LetsTryThis()

    #Grab apple pics.
    Applefiles = LTT.getImages("ApplesToOranges/Images/Apples/", ImageSize)
    #Loop and add label for apple pics
    print("Apples:"+str(len(Applefiles)))
    for item in Applefiles:
        labels.append(1)

    #Grab organge pics
    Orangefiles = LTT.getImages("ApplesToOranges/Images/Oranges/", ImageSize)
    #Loop and add label for apple pics
    print("Oranges:"+str(len(Orangefiles)))
    for item in Orangefiles:
        labels.append(0)

    AllFiles = Applefiles + Orangefiles

    #LTT.showImage(files[0])
    print("How many files do we have?:"+ str(len(labels)))


    listofpatches = LTT.ReshapeListOfImages(AllFiles[:], ImageSize)
    #listObject = LTT.IDk()
    print("How many images do we have?:"+ str(len(listofpatches)))


    #print(labels)

    X_train, X_test, y_train, y_test = sklearn.cross_validation.train_test_split(listofpatches[:], labels[:], test_size=0.1)

    #print(y_train)

    X_train2 = []
    Y_train2 = []

    for i in range(0, 2000):
        X_train2.append([random.randint(50, 100), random.randint(50, 100)])
        Y_train2.append(0)
        X_train2.append([random.randint(0, 50), random.randint(0, 50)])
        Y_train2.append(1)

    print(X_train2)

    #X_train2 = [[0, 0], [10, 10], [0, 0], [10, 10], [0, 0], [0, 0], [0, 0], [11, 11], [0, 0], [12, 12], [0, 0], [0, 0]]

    #clf = svm.SVR()
    clf = MiniBatchKMeans(n_clusters=2, max_iter=5)
    clf = clf.fit(X_train2)
    clf._get_param_names()


    print(clf.predict([[0, 0], [0, 0], [0, 0], [0, 0], [10, 10]]))
    #print(clf.predict(X_train2))
    #print(y_test)
    print(clf.cluster_centers_[:])


    adjustedarray = np.around(clf.cluster_centers_[:], decimals=2)
    #print(adjustedarray)

    xforplt = []
    yforplt = []

    print("----")
    print(clf.labels_)
    print("----")
    for item in X_train2:
        xforplt.append(item[0])
        yforplt.append(item[1])


    plt.scatter(xforplt, yforplt)
    plt.scatter(clf.cluster_centers_[:, 0], clf.cluster_centers_[:, 1], marker='+', c='r')
    plt.show()

    '''

    #clf = tree.DecisionTreeClassifier()
    clf = svm.SVR()
    clf = clf.fit(X_train, y_train)




    #secondClassifier = svm.SVC()
    #secondClassifier.fit(X_train, y_train)
    #print(listofpatches[0])
    #print("SecondClassResults:")
    #print(secondClassifier.predict(X_test))
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

    for item, labelname, guess in zip(X_test, y_test, results):
        array21 = np.reshape(item, (ImageSize, ImageSize, 3))
        #print(array21)
        plt.imshow(array21)
        plt.title("Answer:" + str(labelname) + " Guess:" + str(guess))
        axnext = plt.axes([0.1, 0.1, 0.1, 0.1])
        bnext = Button(axnext, 'Next')
        bnext.on_clicked(LTT.addImagetoModule(clf, [item], [labelname]))

        plt.show()

    #array21 = np.reshape(X_test[0], (ImageSize, ImageSize, 3))
    #print(array21)
    #plt.imshow(array21)
    #plt.show()
    #LTT.showImage(files[-1])
    '''