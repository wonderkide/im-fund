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

	query = "SELECT id,name FROM fund"
	cursor.execute(query)
	records = cursor.fetchall()
	db.close()
	if records:
		return records
	else:
		return NULL


def getUserLineId(user_id):
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT user_id FROM users WHERE id = %s ORDER BY update_time"
	cursor.execute(query, (user_id,))
	records = cursor.fetchone()
	db.close()
	if records:
		return records[0]
	else:
		return NULL

def getType(msg_type):
	if msg_type == 'text':
		return 1
	elif msg_type == 'image':
		return 2
	elif msg_type == 'sticker':
		return 3
	else:
		return 99


def InsertData(line_id, user, data, msg_type, reply = 0):
	db = connectDb()
	cursor = db.cursor()

	msg_type = getType(msg_type)
	
	row_id = setUser(line_id, user, data, msg_type)
	#print(row_id)
	
	query = "INSERT INTO messages (line_id, user_id, msg, type, reply, create_time, active) VALUES (%s, %s, %s, %s, %s, %s, %s)"
	values = (line_id, row_id, data, msg_type, reply, int(time.time()), 0)
	cursor.execute(query, values)
	db.commit()
	db.close()

	#print(cursor.rowcount, "record inserted")
	UpdateLineAccess(line_id)
	
	return

def InsertReplyData(user, data, msg_type, reply, admin):
	db = connectDb()
	cursor = db.cursor()

	msg_type = getType(msg_type)

	line_id = getLineTableByUser(user)
	
	query = "INSERT INTO messages (line_id, user_id, msg, type, reply, reply_admin_id, create_time, active) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
	values = (line_id, user, data, msg_type, reply, admin, int(time.time()), 1)
	cursor.execute(query, values)
	db.commit()
	db.close()

	UpdateUserAccess(user, data, msg_type)
	UpdateLineAccess(line_id)

	return

def UpdateUserAccess(user, msg, msg_type):
	db = connectDb()
	cursor = db.cursor()

	last_msg = setLastMsg(msg, msg_type)

	cursor.execute ("""UPDATE users SET last_msg=%s, update_time=%s WHERE id=%s""", (last_msg, int(time.time()), user))
	db.commit()
	db.close()

def UpdateLineAccess(line_id):
	db = connectDb()
	cursor = db.cursor()

	cursor.execute ("""UPDATE line SET access_time=%s WHERE id=%s""", (int(time.time()), line_id))
	db.commit()
	db.close()

def getLineTableByUser(user_id):
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT line_id FROM users WHERE id = %s ORDER BY update_time"
	cursor.execute(query, (user_id,))
	records = cursor.fetchone()
	db.close()
	if records:
		return records[0]
	else:
		return NULL

def SelectData(user_id = "U299d81c47c1c2f11b900e37a2046b091"):
	db = connectDb()
	cursor = db.cursor()
	
	query = "SELECT * FROM messages WHERE user_id = %s ORDER BY create_time"
	cursor.execute(query, (user_id,))
	records = cursor.fetchall()
	'''
	for record in records:
		print(record)
	'''
	db.close()
	return records

def DeleteData():
	db = connectDb()
	cursor = db.cursor()
	
	## defining the Query
	query = "DELETE FROM msg WHERE user_id = 5"

	## executing the query
	cursor.execute(query)

	## final step to tell the database that we have changed the table data
	db.commit()
	db.close()

def UpdateData():
	db = connectDb()
	cursor = db.cursor()
	
	## defining the Query
	query = "UPDATE msg SET name = 'Kareem' WHERE id = 1"

	## executing the query
	cursor.execute(query)

	## final step to tell the database that we have changed the table data
	db.commit()
	db.close()

def setUser(line_id, user, msg, msg_type):
	db = connectDb()
	cursor = db.cursor()

	last_msg = setLastMsg(msg, msg_type)
	
	#print(user.user_id)
	name = user.display_name
	user_line_id = user.user_id
	pic = user.picture_url
	status = user.status_message
	query = "SELECT * FROM users WHERE user_id=%s AND line_id=%s"
	cursor.execute(query, (user_line_id, line_id,))
	
	records = cursor.fetchall()
	print(name)
	print(status)
	#teststring = str(status)
	#print(teststring)
	#name = name.encode(encoding='utf-8')
	#status = status.encode(encoding='utf-8')
	#name = name.encode('unicode_escape')
	#status = status.encode('unicode_escape')
	#decode = teststring.decode('unicode_escape')
	#print(teststring)
	#status = teststring
	#name = re.escape(name)
	#tatus = re.escape(status)
	print(name)
	print(status)
	#print(str(status, encoding='utf-8'))

	'''
	if name:
		name = deEmojify(name)
		name = name.replace("'", "")
		name = name.replace('"', "")
	if status:
		status = deEmojify(status)
		status = status.replace('"', "")
		status = status.replace("'", "")

	'''

	#row_count = cursor.rowcount


	'''
	if records:

		print(records)
	else:
		print('sadadasdd')

	'''
	
	if records:
		#print(records[0][0])
		record_id = records[0][0]
		#cursor.close()
		#cursor = db.cursor()
		#update = "UPDATE users SET display_name=%s, picture_url=%s, status_message=%s WHERE id=%s" % (name, pic, status, record_id)
		#update = "UPDATE users SET display_name = name, picture_url = pic, status_message = status WHERE id = record_id"
		#print(record_id)
		cursor.execute ("""UPDATE users SET display_name=%s, picture_url=%s, status_message=%s, last_msg=%s, activity_status=1, update_time=%s WHERE id=%s""", (name, pic, status, last_msg, int(time.time()), record_id))
		#cursor.execute(update)
		db.commit()
		db.close()
		return record_id
	else:
		#print(row_count)
		#cursor.close()
		insert = "INSERT INTO users (line_id, user_id, display_name, picture_url, status_message, last_msg, activity_status, update_time) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
		values = (line_id, user_line_id, name, pic, status, last_msg, 1, int(time.time()))
		cursor.execute(insert, values)
		db.commit()
		db.close()
		return cursor.lastrowid
	
	#records = cursor.fetchall()
	
	#for record in records:
	#	print(record)

#print(SelectData())

def setLastMsg(msg, msg_type):
	if msg_type == 1:
		return msg
	elif msg_type == 2:
		return "{ image }"
	elif msg_type == 3:
		return "{ sticker }"
	else:
		return "{ message }"

def getAdminBotId():
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT id FROM db_admin WHERE username = %s"
	cursor.execute(query, ('bot',))
	records = cursor.fetchone()
	db.close()
	if records:
		return records[0]
	else:
		return NULL


def getDepositMsgByLineId(line_id):
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT deposit_message_reply_id FROM line WHERE id = %s"
	cursor.execute(query, (line_id,))
	records = cursor.fetchone()
	db.close()
	if records:
		return getMsgPatternById(records[0])
	else:
		return NULL

def getMsgPatternById(id):
	db = connectDb()
	cursor = db.cursor()

	query = "SELECT msg FROM messages_reply WHERE id = %s"
	cursor.execute(query, (id,))
	records = cursor.fetchone()
	db.close()
	if records:
		return records[0]
	else:
		return NULL

def InsertSlipLog(line_id, user_id, txt, rsp, push_msg):
	if insert_slip_log:
		db = connectDb()
		cursor = db.cursor()
		
		query = "INSERT INTO send_slip_log (line_id, user_id, txt, response, push_message, create_time) VALUES (%s, %s, %s, %s, %s, %s)"
		values = (line_id, user_id, txt, rsp, push_msg, int(time.time()))
		cursor.execute(query, values)
		db.commit()
		db.close()
	
	return
