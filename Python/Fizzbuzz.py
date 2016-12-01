Author = "EdEvanosich"

class FizzBuzz():
    def __init__(self):
        print("Im Initializing... Oh Snap!")



    def DoTheThing(self, x=100):
        '''
        Print the numbers 1 from 100.
        But for multiples of 3 print "Fizz"
        And For multiples of 5 print "Buzz"
        For multiples of both, print "FizzBuzz"
        '''

        for i in range(1, x):
            if i >= 3 and  i % 3 == 0:
                print("Fizz")

                if i >= 5 and i % 5 == 0:
                    print("FizzBuzz")

            elif i >= 5 and i % 5 == 0:
                print("Buzz")

            else:
                print(i)

if __name__ == "__main__":
    FB = FizzBuzz()         #simple class.
    FB.DoTheThing()         #Fizz Bizzness.