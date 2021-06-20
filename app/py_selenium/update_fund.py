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

def set_nav_date_format(dt):
	time_split = dt.split("/")
	dt_date = time_split[0]
	dt_month = time_split[1]


	#today = date.today()
	#year = today.strftime('%Y')
	now = datetime.now()

	new_date = str(now.year) + '-' + dt_month + '-' + dt_date

	return new_date

def check_dividend(d):
	if d == 'จ่าย':
		return 1
	else:
		return 0

def check_fee_text(txt):
	if txt == 'ยกเว้น' or txt == 'ไม่มี' or txt == '-' or txt == 'ยกเว้นการเรียกเก็บ' or txt == 'ยกเว้น ไม่เรียกเก็บ' or txt == '':
		return 0
	else:
		x = txt.replace("%", "").strip()
		return x

def check_replace_text(txt):
	txt = txt.replace("ต่อปี", "")
	txt = txt.replace("%", "")
	txt = txt.replace(",", "")
	txt = txt.replace("บาท", "")
	txt = txt.replace("-", "")

	txt = txt.strip()

	if txt == '':
		return 0
	else:
		return txt

def set_date_register(d):
	time_split = dt.split(" ")
	dt_date = time_split[0]
	dt_month = time_split[1]
	dt_year = time_split[1]

def check_month_thai(m):
	if m == 'ม.ค.':
		return '01'
	elif m == 'ก.พ.':
		return '02'
	elif m == 'มี.ค.':
		return '03'
	elif m == 'เม.ย.':
		return '04'
	elif m == 'พ.ค.':
		return '05'
	elif m == 'มิ.ย.':
		return '06'
	elif m == 'ก.ค.':
		return '07'
	elif m == 'ส.ค.':
		return '08'
	elif m == 'ก.ย.':
		return '09'
	elif m == 'ต.ค.':
		return '10'
	elif m == 'พ.ย.':
		return '11'
	elif m == 'ธ.ค.':
		return '12'
	else:
		return '01'

"""
def check_number(number):
	x = number.isnumeric()
	if x == True:
		return number
	else:
		return 0
"""

def check_number(s):
	return s


def findFund(fund):
	f_id = fund[0]
	f_name = fund[1]
	url = 'https://www.finnomena.com/fund/'+f_name
	#driver = webdriver.Chrome('./webdriver/chromedriver')

	options = webdriver.ChromeOptions()
	options.add_argument('--headless')
	driver = webdriver.Chrome('./webdriver/chromedriver', options=options) 

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

	risk_block_text = risk_block[0].text

	fedder_fund = driver.find_elements_by_xpath('//*[@id="fund-data-detail"]/div/div[1]/div[5]/div[2]')



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
	nav_date_text = set_nav_date_format(nav_date_text)

	fund_type_text = fund_type[0].text.strip()

	risk_text = risk_block_text.split("-")[0].strip()
	risk_text = check_number(risk_text)
	

	fedder_fund = fedder_fund[0].text.strip()

	cur_policy_text = cur_policy[0].text.strip()

	dividend_text = dividend[0].text.strip()
	dividend_text = check_dividend(dividend_text)
	dividend_text = check_number(dividend_text)


	frontend_text = frontend[0].text.strip()
	frontend_text = check_fee_text(frontend_text)
	frontend_text = check_number(frontend_text)

	backend_text = backend[0].text.strip()
	backend_text = check_fee_text(backend_text)
	backend_text = check_number(backend_text)

	fee_text = fee[0].text.strip()
	fee_text = check_replace_text(fee_text)
	fee_text = check_number(fee_text)


	first_in_text = first_in[0].text.strip()
	first_in_text = check_replace_text(first_in_text)
	first_in_text = check_number(first_in_text)

	after_in_text = after_in[0].text.strip()
	after_in_text = check_replace_text(after_in_text)
	after_in_text = check_number(after_in_text)

	date_text = date[0].text.strip()

	value_text = value[0].text.strip()
	value_text = check_replace_text(value_text)

	db.updateFund(f_id, name_th_text, nav_text, nav_date_text, fund_type_text, risk_text, fedder_fund, cur_policy_text, dividend_text, frontend_text, backend_text, fee_text, first_in_text, after_in_text, date_text, value_text)

	print('NAME : ' + name_th_text)
	print('NAV : ' + nav_text)
	print('DATE : ' + nav_date_text)
	print('TYPE : ' + fund_type_text)
	print('RISK : ' + str(risk_text))
	print('cur_policy_text : ' + cur_policy_text)
	print('DIVIDEND : ' + str(dividend_text))

	print('frontend : ' + str(frontend_text))
	print('backend : ' + str(backend_text))
	print('fee : ' + str(fee_text))
	print('first_in : ' + str(first_in_text))
	print('after_in : ' + str(after_in_text))
	print('date : ' + date_text)
	print('value : ' + value_text)



	driver.close()

fund = db.getFundAll()

for f in fund:
	print(f[1])
	findFund(f)