#!/usr/bin/env python2

import sqlite3
from xbee import ZigBee
import serial
from struct import pack
import argparse
import time

parser = argparse.ArgumentParser(description='RedQueen door system daemon.')
parser.add_argument('--baud-rate', type=int, default=115200)
parser.add_argument('--serial-port', default='ttyUSB0')
parser.add_argument('--database', required=True)

args = parser.parse_args()

conn = sqlite3.connect(args.database)
ser = serial.Serial( '/dev/%s' % args.serial_port, args.baud_rate)
xbee = ZigBee(ser)

print "BOOTED"

# Continuously read and print packets
while True:
    try:
        response = xbee.wait_read_frame()
        print response

        if 'rf_data' in response:
            door_card, pin = response['rf_data'].split(':')

            print "Card ", door_card, " PIN ", pin

            c = conn.cursor()
            c.execute('SELECT * FROM cards WHERE code = ? AND pin = ?', (door_card, pin))
            card = c.fetchone()

            if card == None:
                print "No card found"
            else:
                print card
                print { 'data': pack('>bL', 0, 5) }
                xbee.send('tx', dest_addr=response['source_addr'], dest_addr_long=response['source_addr_long'], data=pack('>bL', 0, 5))

            c.close()

            c = conn.cursor()
            c.execute('INSERT INTO log VALUES (NULL, ?, ?)', ( door_card, time.asctime( time.localtime(time.time()) ) ))
            conn.commit()
            c.close()
    except KeyboardInterrupt:
        break

conn.close()
ser.close()
