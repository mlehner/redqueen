#include <stdio.h>
#include <sys/io.h>
#include <stdlib.h>

//
// LPT 8-Bit Relay Trigger, for Buffalo Hacker Space
//
// Version: 1.0
// Copyright: synace
//            http://synace.com
// Date: Sep 17, 2009
// License: GPL
//
/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

main(int argc, char **argv) {
   if (argc == 5) {
     int base = strtol(argv[1], (char**)NULL, 16);
     int value = strtol(argv[2], (char**)NULL, 10);
     int duration = strtol(argv[3], (char**)NULL, 10);
     int pause = strtol(argv[4], (char**)NULL, 10);

     printf("Port: 0x%x Value: %d Duration: %d Pause: %d\n", base, value, duration, pause);

     if (ioperm(base, 1, 1)) {
      printf("Couldn't get the port at 0x%x\n", base);
     } else {
       sleep(pause);
       outb(value, base);
       sleep(duration);
       outb(0x0, base);
     }
  } else {
    printf("LPT 8-Bit Relay Trigger, for Buffalo Hacker Space\n    Version: 1.0\n    Copyright: synace\n               http://synace.com\n    Date: Sep 17, 2009\n    License: GPL\n\nUsage: %s [base-address] [value] [duration] [pause]\n  base-address: 0x378, for example\n  value: 8 bits: 1, 2, 4, 8, 16, 32, 64, 128, or combinations of them, 255 = all\n  duration: 5, for example. in seconds.\n  pause: 1, for example. in seconds.\n\n", argv[0]);
  }
}
