__author__ = 'root'


from multiprocessing import Process
import threading
import time
import os



class threadex:
    def x(self):
        for i in range(10):
            threading.Thread(target=self.countdown, args=(i,)).start()

    def countdown(self, num):
        waittime = 15
        while waittime > 0:
            waittime -= 1
            a = 0
            for i in range(1000000):
                a += 1

            print(a)
            print("ThreadEx:" + str(num) + " : sleeping for " + str(waittime) + " seconds.")


class multiex:
    def x(self):
         for i in range(250):
            Process(target=self.countdown, args=(i,)).start()

    def countdown(self, num):
        waittime = 15
        while waittime > 0:
            waittime -= 1
            a = 0
            for i in range(1000000):
                a += 1

            print(a)
            print("MultiEx:" + str(num) + " : sleeping for " + str(waittime) + " seconds.")


if __name__ == "__main__":


    threadclass = threadex()
    multiclass  = multiex()




    #threading.Thread(target=threadclass.x, args=()).start()
    Process(target=multiclass.x, args=()).start()

