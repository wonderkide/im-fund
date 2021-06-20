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

url = config.url

#driver = webdriver.Chrome('./webdriver/chromedriver')

#driver.get(url)

#result_nav = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, ".fund-nav-percent")))

#print(result_nav.text)

options = webdriver.ChromeOptions()

options.add_argument('--headless')

#driver = webdriver.Chrome('./webdriver/chromedriver', options=options) 
driver = webdriver.Chrome('./webdriver/chromedriver')

driver.get(url)

name_th = driver.find_elements_by_xpath('//*[@id="fund-header"]/div[1]/p')

nav_block = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, ".fund-nav-percent")))
nav = WebDriverWait(nav_block, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, "h3")))
nav_date = WebDriverWait(nav_block, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, "p")))


#detail_left = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[1]/div')

#fund_type = detail_left[0]

#print(yadsad[0].text)

#for tr in driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[1]/div'):
#	print(tr.text)


fund_type = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[1]/div[3]/div[2]')
risk_block = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[1]/div[4]/div[2]')

#print(risk_block[0].text)

risk_block_text = risk_block[0].text

cur_policy = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[1]/div[6]/div[2]')

dividend = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[1]/div[7]/div[2]')

frontend = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[2]/div[1]/div[2]')

backend = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[2]/div[2]/div[2]')

fee = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[2]/div[3]/div[2]')
first_in = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[2]/div[4]/div[2]')
after_in = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[2]/div[5]/div[2]')
date = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[2]/div[6]/div[2]')
value = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[2]/div[7]/div[2]')


name_th_text = name_th[0].text.strip()
nav_text = nav.text.strip()
nav_date_text = nav_date.text.strip()
fund_type_text = fund_type[0].text.strip()
risk_text = risk_block_text.split("-")[0].strip()
cur_policy_text = cur_policy[0].text.strip()
dividend_text = dividend[0].text.strip()
frontend_text = frontend[0].text.strip()
backend_text = backend[0].text.strip()
fee_text = fee[0].text.strip()
first_in_text = first_in[0].text.strip()
after_in_text = after_in[0].text.strip()
date_text = date[0].text.strip()
value_text = value[0].text.strip()

print('NAME : ' + name_th_text)
print('NAV : ' + nav_text)
print('DATE : ' + nav_date_text)
print('TYPE : ' + fund_type_text)
print('RISK : ' + risk_text)
print('cur_policy_text : ' + cur_policy_text)
print('DIVIDEND : ' + dividend_text)

print('frontend : ' + frontend_text)
print('backend : ' + backend_text)
print('fee : ' + fee_text)
print('first_in : ' + first_in_text)
print('after_in : ' + after_in_text)
print('date : ' + date_text)
print('value : ' + value_text)

#print(left_row[3].text)

driver.close()