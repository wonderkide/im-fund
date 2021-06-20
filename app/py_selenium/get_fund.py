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


def getFundByAsset(asset):
	a_id = asset[0]
	a_code = asset[1]
	url = 'https://www.finnomena.com/fund/filter?amc='+a_code+'&size=1000'
	#driver = webdriver.Chrome('./webdriver/chromedriver')

	options = webdriver.ChromeOptions()
	options.add_argument('--headless')
	driver = webdriver.Chrome('./webdriver/chromedriver', options=options) 

	driver.get(url)



	for tr in driver.find_elements_by_xpath('//*[@id="fund-filter-table"]/div[1]/div/div[2]/div[1]/div/div[1]/div'):
		tr_text = tr.text
		if tr_text != 'ชื่อกองทุนรวม':
			#print(tr_text)

			check = db.checkFund(tr_text)
			if check == False:
				db.insertFund(a_id, tr_text)
				print(tr_text)

	driver.close()


asset = db.getAssetAll()

for a in asset:
	print(a[1])
	getFundByAsset(a)

#print(fund)

"""

url = 'https://www.finnomena.com/fund/filter?amc=0C00001KVS&page=1&period=1Y';

driver = webdriver.Chrome('./webdriver/chromedriver')

driver.get(url)

#table = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, ".table-sticky")))

#fund_row = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, ".fund-name")))

for tr in driver.find_elements_by_xpath('//*[@id="fund-filter-table"]/div[1]/div/div[2]/div[1]/div/div[1]/div'):

	#tr_text = WebDriverWait(tr, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, ".fund-name")))
	tr_text = tr.text
	if tr_text != 'ชื่อกองทุนรวม':
		print(tr_text)

driver.close()
"""