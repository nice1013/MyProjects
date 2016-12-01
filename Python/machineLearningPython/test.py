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
        img = Image.open('Images/Apples/apple_1.jpeg')
        img = img.resize((pixels,pixels), Image.ANTIALIAS)
        return img
        #plt.imshow(img)
        #plt.show()

    def showImage(self, file):
        plt.imshow(file)
        plt.show()

if __name__ == '__main__':
    #Height - Offense Defense
    ImageSize = 10
    labels = []

    #Instantiate the class.
    LTT = LetsTryThis()

    #Grab apple pics.
    files = LTT.getImages("Images/Apples/", ImageSize)
    #Loop and add label for apple pics
    for item in files:
        labels.append("Apple")

    #Grab organge pics
    files += LTT.getImages("Images/Oranges/", ImageSize)
    #Loop and add label for apple pics
    for item in files:
        labels.append("Orange")

    #LTT.showImage(files[0])
    print("How many files do we have?:"+ str(len(files)))


    listofpatches = LTT.ReshapeListOfImages(files[:], ImageSize)
    #listObject = LTT.IDk()
    print("How many images do we have?:"+ str(len(listofpatches)))


    #print(labels)

    X_train, X_test, y_train, y_test = sklearn.cross_validation.train_test_split(listofpatches[:], labels[:], test_size=0.1)

    print(y_train)

    clf = tree.DecisionTreeClassifier()
    clf = clf.fit(X_train, y_train)

    #print(listofpatches[0])

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
    print clf.predict(X_test)

    array21 = np.reshape(X_test[0], (ImageSize, ImageSize, 3))
    #print(array21)
    plt.imshow(array21)
    plt.show()
    #LTT.showImage(files[-1])



    '''
    print(__doc__)

    # Author: Gael Varoquaux <gael dot varoquaux at normalesup dot org>
    # License: BSD 3 clause

    # Standard scientific Python imports
    import matplotlib.pyplot as plt

    # Import datasets, classifiers and performance metrics
    from sklearn import datasets, svm, metrics

    # The digits dataset
    digits = datasets.load_digits()

    # The data that we are interested in is made of 8x8 images of digits, let's
    # have a look at the first 3 images, stored in the `images` attribute of the
    # dataset.  If we were working from image files, we could load them using
    # pylab.imread.  Note that each image must have the same size. For these
    # images, we know which digit they represent: it is given in the 'target' of
    # the dataset.
    images_and_labels = list(zip(digits.images, digits.target))
    for index, (image, label) in enumerate(images_and_labels[:4]):
        plt.subplot(2, 4, index + 1)
        plt.axis('off')
        plt.imshow(image, cmap=plt.cm.gray_r, interpolation='nearest')
        plt.title('Training: %i' % label)

    # To apply a classifier on this data, we need to flatten the image, to
    # turn the data in a (samples, feature) matrix:
    n_samples = len(digits.images)


    data = digits.images.reshape((n_samples, -1))

    # Create a classifier: a support vector classifier
    classifier = svm.SVC(gamma=0.001)

    # We learn the digits on the first half of the digits
    classifier.fit(data[:n_samples / 2], digits.target[:n_samples / 2])

    # Now predict the value of the digit on the second half:
    expected = digits.target[n_samples / 2:]
    predicted = classifier.predict(data[n_samples / 2:])

    print("Classification report for classifier %s:\n%s\n"
          % (classifier, metrics.classification_report(expected, predicted)))
    print("Confusion matrix:\n%s" % metrics.confusion_matrix(expected, predicted))

    images_and_predictions = list(zip(digits.images[n_samples / 2:], predicted))
    for index, (image, prediction) in enumerate(images_and_predictions[:4]):
        plt.subplot(2, 4, index + 5)
        plt.axis('off')
        plt.imshow(image, cmap=plt.cm.gray_r, interpolation='nearest')
        plt.title('Prediction: %i' % prediction)

    plt.show()
    '''