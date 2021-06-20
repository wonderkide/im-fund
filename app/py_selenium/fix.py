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
username = config.username
password = config.password


'''
desired_cap = {
'browserName': 'android',
'device': 'Samsung Galaxy Note 9',
'realMobile': 'true',
'os_version': '8.1',
'name': 'Bstack-[Python] Sample Test'
}
'''

#driver = webdriver.Remote(
#command_executor='https://shaumikdaityari1:pnZpugbbuzZusdRaiKcx@hub.browserstack.com:80/wd/hub',
#desired_capabilities=desired_cap)

def set_time_format(kickoff_datetime):
	time_split = kickoff_datetime.split(" ")
	match_date_month = time_split[0]
	time = time_split[1]

	if time == '**:**':
		return ''

	match_date_month_split = match_date_month.split("/")

	match_date = match_date_month_split[1]
	match_month = match_date_month_split[0]


	yesterday = date.today() - timedelta(days=1)
	year = yesterday.strftime('%Y')

	new_datetime = year + '-' + match_month + '-' + match_date + ' ' + time + ':00'

	mytime = datetime.strptime(new_datetime, "%Y-%m-%d %H:%M:%S")
	mytime -= timedelta(hours=1)

	current_my_datetime = mytime.strftime('%Y-%m-%d %H:%M:%S')

	return current_my_datetime

def RepresentsInt(s):
    try: 
        score = int(s)
        return score
    except ValueError:
        return ''

def checkJson(jsonContents, home, away):
    bodyFlag = True if "team_home" in jsonContents["ScoreData"] and jsonContents["ScoreData"] == home else False
    codeFlag = True if "team_away" in jsonContents["ScoreData"] and jsonContents["ScoreData"] == away else False

    return bodyFlag and codeFlag

driver = webdriver.Chrome('./webdriver/chromedriver')

driver.get(url)

username_box = driver.find_element_by_id("username")
password_box = driver.find_element_by_id("password")

username_box.send_keys(username)
password_box.send_keys(password)

driver.find_element_by_class_name("sign-in").click()

'''
try:
	#popup = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, "div.popup")))
	WebDriverWait(driver, 20)
	driver.find_element_by_class_name("999999999999999999").click()
except NoSuchElementException:
	print("No popup")

'''

result_link = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, "li.main-header-function-item.Nike_MainHeader_Text_Result")))

driver.find_element_by_class_name("Nike_MainHeader_Text_Result").click()

main_window = driver.window_handles[0]
new_window = driver.window_handles[1]
driver.switch_to_window(new_window)

yesterday_result_link = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.CSS_SELECTOR, "input.buttonstyle2")))

driver.find_element_by_name("Yesterday").click()

data = {}
data['ScoreData'] = []

WebDriverWait(driver, 10)

yesterday_result_table = WebDriverWait(driver, 20).until(EC.visibility_of_element_located((By.XPATH, './/*[@id="resultDiv"]/table/tbody/tr')))

skip = False

for tr in driver.find_elements_by_xpath('.//*[@id="resultDiv"]/table/tbody/tr'):

	try:
		element = tr.find_element_by_xpath('.//td[1]')
	except NoSuchElementException:
		print("Header")
		continue

	tr_class = tr.get_attribute("class")
	if tr_class == 'tr_odd' or tr_class == 'tr_even':
		cccc = tr_class
		#print('')
	else:
		league = tr.find_element_by_xpath('.//td[1]')
		if 'Which team will advance to next round' in league.text:
			if skip == False:
				skip = True

			print(league.text)
		else:
			if skip == True:
				skip = False
		continue

	if skip == True:
		print('Which team will advance to next round')
		continue

	time = tr.find_element_by_xpath('.//td[1]').text
	time_format = set_time_format(time);
	if time_format == '':
		print('no time')
		status = 0
		continue

	team = tr.find_element_by_xpath('.//td[2]')
	team_h = team.find_element_by_xpath('.//span[1]').text
	team_a = team.find_element_by_xpath('.//span[2]').text
	if team_a == '':
		team_a = team.find_element_by_xpath('.//span[3]').text

	if team_a == '':
		team_a = team.find_element_by_xpath('.//span[4]').text

	status = 1
	home_score = 0
	away_score = 0

	score = tr.find_element_by_xpath('.//td[4]').text
	if score == 'Refunded':
		print('Refunded')
		status = 0
	else:
		score_replace = score.replace(" ", "")
		score_arr = score_replace.split(":")
		try:
			score_arr[0]
			score_arr[1]
			home_score = RepresentsInt(score_arr[0])
			away_score = RepresentsInt(score_arr[1])
		except IndexError:
			print('Skip match cant find score or ABD')
			status = 0
			continue

	if home_score == '' or away_score == '':
		print('Skip match score not found')
		status = 0
		continue

	print(team_h + ' ' + str(home_score) + ' : ' + str(away_score) + ' ' + team_a)

	data['ScoreData'].append({'team_home': team_h, 'home_score': home_score, 'away_score': away_score, 'kickoff_time': time_format,  'team_away': team_a, 'status' : status})

with open('score_data.json', 'w') as outfile:
    json.dump(data, outfile)

driver.close()
driver.switch_to_window(main_window)
driver.close()