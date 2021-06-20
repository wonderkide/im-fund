#!/usr/bin/python3

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException
from datetime import datetime, date, timedelta
import json

# Import modules
import subprocess, sys, os   
script_path = os.path.dirname(__file__)
config_path = os.path.join(script_path, '../config')
sys.path.append(config_path)

import config
import db

def findFund(fund):
	f_id = fund[0]
	f_name = fund[1]
	url = 'https://www.finnomena.com/fund/'+f_name
	#driver = webdriver.Chrome('./webdriver/chromedriver')

	options = webdriver.ChromeOptions()
	options.add_argument('--headless')
	driver = webdriver.Chrome('./webdriver/chromedriver', options=options) 

	driver.get(url)

	nav_block = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, ".fund-nav-percent")))
	nav = WebDriverWait(nav_block, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, "h3")))
	nav_date = WebDriverWait(nav_block, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, "p")))



	driver.close()

fund = db-getFundAll()

for f in fund:
	print(f[1])
	findFund(f)