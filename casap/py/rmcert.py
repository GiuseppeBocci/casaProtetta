#!/usr/bin/python3
"""Avviare il programma da 'casap/' con 'sudo Python3 py/rmcert.py &'"""
import os
import sys
import time

while True:
    command = "rm -f certs/*.*"
    os.system(command)
    time.sleep(60)
