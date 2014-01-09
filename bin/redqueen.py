#!/usr/bin/env python2

import sqlite3
from xbee import ZigBee
import serial
from struct import pack
import argparse
import time
import sys

parser = argparse.ArgumentParser(description='RedQueen door system daemon.')
parser.add_argument('--baud-rate', type=int, default=115200)
parser.add_argument('--serial-port', default='ttyUSB0')
parser.add_argument('--database', required=True)

args = parser.parse_args()

conn = sqlite3.connect(args.database)
ser = serial.Serial( '/dev/%s' % args.serial_port, args.baud_rate)
xbee = ZigBee(ser)

print "BOOTED"
sys.stdout.flush()

# Continuously read and print packets
while True:
    try:
        response = xbee.wait_read_frame()
        print response
	sys.stdout.flush()

        if 'rf_data' in response:
            door_card, pin = response['rf_data'].split(':')

            print "Card ", door_card, " PIN ", pin
            sys.stdout.flush()

            c = conn.cursor()
            c.execute('SELECT id,pin FROM cards WHERE code = ?', (door_card, ))
            card = c.fetchone()
            
            valid_pin = False

            if card is None:
                print "No card found"
                sys.stdout.flush()
            elif card[1] == pin:
                print "Found card, valid pin... opening door!"
                valid_pin = True
                print { 'data': pack('>bL', 0, 5) }
                sys.stdout.flush()
                xbee.send('tx', dest_addr=response['source_addr'], dest_addr_long=response['source_addr_long'], data=pack('>bL', 0, 5))
            else:
                print "Found card, invalid pin"
                sys.stdout.flush()

            c.execute('INSERT INTO log VALUES (NULL, ?, ?, ?, ?)', ( card[0] if card else None, door_card, valid_pin, time.time() ))

            conn.commit()

            c.close()
    except KeyboardInterrupt:
        break

conn.close()
ser.close()
