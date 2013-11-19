#!/usr/bin/env python2

import sqlite3

conn = sqlite3.connect('/home/matt/buffalolab/redqueen/redqueen.sqlite')

c = conn.cursor()

code = 'blah'
pin = 1234

c.execute('SELECT * FROM cards WHERE code = ? AND pin = ?', (code, pin))

card = c.fetchone()

if card == None:
    print "No card found"
else:
    print card
