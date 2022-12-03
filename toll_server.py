#!/usr/bin/env python3
import serial
import urllib.request


if __name__ == '__main__':
    ser = serial.Serial('/dev/ttyACM1', 9600, timeout=1)
    ser.flush()
    while True:
        if ser.in_waiting > 0:
            value = ser.readline().decode('utf-8').rstrip()
            print(value)
            add = "http://bridgetoll.000webhostapp.com/index.php?"
#             value = "license=34567&bridge=102"
            add += value
            with urllib.request.urlopen(add) as url:
                data = url.read()
                print(data)
                ser.write(data)