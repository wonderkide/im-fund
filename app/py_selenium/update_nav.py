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
import urllib.parse

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

	f_name_encode = urllib.parse.quote(f_name)
	f_name_encode = f_name_encode.replace("/", "%2F")
	
	url = 'https://www.finnomena.com/fund/'+f_name_encode
	#driver = webdriver.Chrome('./webdriver/chromedriver')

	options = webdriver.ChromeOptions()
	options.add_argument('--headless')
	driver = webdriver.Chrome('./webdriver/chromedriver', options=options) 
	#driver.implicitly_wait(20)
	driver.get(url)


	nav = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.XPATH, '//*[@id="fund-nav-share"]/div[1]/div/h3')))

	nav_text = nav.text.strip()

	if nav_text == '':
		nav = driver.find_elements_by_xpath('//*[@id="fund-nav-share"]/div[1]/div/h3')
		nav_text = nav[0].text.strip()
		print('fucking cannot get NAV')
		driver.close()
		return



	print(nav_text)

	db.updateNav(f_id, nav_text)

fund = db.getFundPortList()

if fund:
	for f in fund:
		print(f[1])
		findFund(f)
else:
	print('noting')
