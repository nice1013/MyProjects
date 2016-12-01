import os
import shutil
from threading import Thread
from pymouse import PyMouse
from pykeyboard import PyKeyboard
import time
import evdev

class MyNewKeyboardThread(Thread):
    def run(self):
        print("Keyboard Thread is starting.")
        #file = open("/dev/input/by-id/usb-Logitech_USB_Keyboard-event-kbd", 'rb')

        device = evdev.InputDevice("/dev/input/by-id/usb-Logitech_USB_Keyboard-event-kbd")
        for event in device.read_loop():
             if event.type == evdev.ecodes.EV_KEY:
                 print(evdev.categorize(event))
                 print(event.code)

class MyNewMouseThread  (Thread):

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
                #print("Direction Up X")
                #print(dy)


class MoveMouse():
    def amount(self, x, y):
        mouse = PyMouse()
        xpos, ypos = mouse.position()

        mouse.move(xpos + x, ypos + y)







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

mouse = PyMouse()
while(True):
    MM.amount(1, 0)
    time.sleep(1)

'''
print(os.path.exists("/dev/input/"))





'''