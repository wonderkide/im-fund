import mysql.connector as mysql
import time
import unicodedata
from unidecode import unidecode

import config

def connectDb():
	db = mysql.connect(
	    host = "localhost",
	    user = config.user,
	    passwd = config.passwd,
	    database = config.database,
	    use_unicode=True,
	    charset='utf8mb4'
	)
	return db

def check_fund_type(name):
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT id FROM fund_type WHERE name_en = %s"
	cursor.execute(query, (name,))
	records = cursor.fetchone()
	db.close()
	if records:
		return records[0]
	else:
		return NULL

def getAssetAll():
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT id,amc_code,name_en FROM asset_management"
	cursor.execute(query)
	records = cursor.fetchall()
	db.close()
	if records:
		return records
	else:
		return NULL

def checkFund(name):
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT id FROM fund WHERE name = %s"
	cursor.execute(query, (name,))
	records = cursor.fetchone()
	db.close()
	if records:
		return True
	else:
		return False

def insertFund(asset_id, fund_name):
	db = connectDb()
	cursor = db.cursor()
	
	query = "INSERT INTO fund (asset_management_id, name, risk, currency_policy, dividend) VALUES (%s, %s, %s, %s, %s)"
	values = (asset_id, fund_name, 0, 4, 0)
	cursor.execute(query, values)
	db.commit()
	db.close()
	
	return

def getFundAll():
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT id,name FROM fund WHERE content_status = %s"
	cursor.execute(query, (0,))
	records = cursor.fetchall()
	db.close()
	if records:
		return records
	else:
		return NULL

def updateFund(fund_id, name_th, nav, nav_date, fund_type, risk, feeder, cur, div, front_fee, end_fee, fee, first, after, re_date, value):
	db = connectDb()
	cursor = db.cursor()

	fund_type_id = check_fund_type(fund_type)

	values = (name_th, nav, nav_date, fund_type_id, risk, feeder, cur, div, front_fee, end_fee, fee, first, after, re_date, value, 1, fund_id)

	cursor.execute ("""UPDATE fund SET name_th=%s, nav=%s, nav_date=%s, fund_type_id=%s, risk=%s, feeder_fund=%s, currency_policy_text=%s, dividend=%s, frontend_fee=%s, backend_fee=%s, fee=%s, first_invest=%s, invest=%s, registration_date_text=%s, net_asset_value=%s, content_status=%s WHERE id=%s""", values)
	db.commit()
	db.close()
