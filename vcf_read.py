import vcf
import mysql.connector
import sys,argparse
import re

def login_to_database(username,db_name):

	config = {
	'user': str(username),
	'database': str(db_name),
	}

	#connect to database using the above fields
	cnx = mysql.connector.connect(**config)
	#create cursor 
	return cnx


def commit_changes_close(cn,cursor):
	cn.commit()
	cursor.close()
	cn.close()


def add_user(username,db_name,password,new_user,new_mail):
	cn = login_to_database(username,db_name)
	cursor = cn.cursor()
	
	add_user = ("INSERT INTO USER "
				"(username, password, email) "
				"VALUES (%s, %s, %s)")

	data_user = (str(new_user),str(password),str(new_mail))

	# Insert new user
	cursor.execute(add_user, data_user)
	emp_no = cursor.lastrowid
	#run the above only the first time
	commit_changes_close(cn,cursor)


def add_file(username,db_name,new_user_id,new_file_name):
	cn = login_to_database(username,db_name)
	cursor = cn.cursor()
	add_file = ("INSERT INTO FILE (file_name,user_id) VALUES (%s,%s)")

	#ena select * from user gia na parete to user_id alliws xalame to constraint user_file_id
	
	cursor.execute(add_file,(str(new_file_name),new_user_id))
	file_user_id=cursor.lastrowid
	commit_changes_close(cn,cursor)
	return file_user_id


def add_vcf(username,db_name,file_id,new_file):
	cn = login_to_database(username,db_name)
	cursor = cn.cursor()
	counter=0
	add_vcf = ("INSERT INTO VCF "
			"(file_id, chromosome, position, id, reference, alternative, quality, filter, information) "
			"VALUES (%s, %s, %s,%s, %s, %s,%s, %s, %s)")

	vcf_reader = vcf.Reader(open(str(new_file), 'r'))
	for record in vcf_reader:

		if (counter>1): 
			break

		cursor.execute(add_vcf, (file_id, record.CHROM,record.POS,record.ID,record.REF,str(record.ALT),str(record.QUAL),str(record.FILTER), str(record.INFO)))
		counter=counter+1

	commit_changes_close(cn,cursor)


def main(dbuser,database,password,existing_username,new_file,new_user,new_mail,new_file_name):
	cn = login_to_database(dbuser,database)
	cursor = cn.cursor()
	user_site_id=0

	#psa3e na breis an iparxei o user idi mesa sto table USER an nai tote proxwra sto na anebaseis to neo file
	if (existing_username is not None):
		query=("SELECT user_id FROM USER WHERE username = %s ")
		cursor.execute(query,(existing_username,))
		print('User Found')

	#an einai neos user tote ftia3e ton kai meta psa3e ton gia to FILE table constraint
	elif (new_user is not None):
		add_user(dbuser,database,password,new_user,new_mail)
		print('User Created')

		cn = login_to_database(dbuser,database)
		cursor = cn.cursor()
		query=("SELECT user_id FROM USER WHERE username = %s ")
		cursor.execute(query,(new_user,))
		
	result=cursor.fetchall()
	commit_changes_close(cn,cursor)

	for row in result:
  		user_site_id = row[0]
	
	if (user_site_id):
		file_user_id=add_file(dbuser,database,user_site_id,new_file_name)
		print ('New File Created')
		print ('Now passing VCF into Database')
		add_vcf(dbuser,database,file_user_id,new_file)
	else:
		print("User Not Found on Database")
		sys.exit(1)

#command line gia na mporesei na pai3ei me to cron
if __name__ == '__main__':
	parser = argparse.ArgumentParser()
	parser.add_argument('--dbuser'	,dest='dbuser', 	action='store') #user tou database, ousiastika o database administrator
	parser.add_argument('--db'		,dest='database', 	action='store') #database of the project
	parser.add_argument('--existing',dest='existing', 	action='store') #site user already exists in database
	parser.add_argument('--new_file_name',dest='new_file_name', 	action='store') #name given by the site user to each uploaded file
	parser.add_argument('--new_file_path',dest='new_file', 	action='store') #full path tou uploaded arxeiou. pou exei sw8ei sto server.
	parser.add_argument('--new_mail',dest='new_mail', 	action='store') #new site user mail field
	parser.add_argument('--new_user',dest='new_user', 	action='store') #new site user name
	parser.add_argument('--p'		,dest='password', 	action='store') #password for the site user, for security reasons

	args = parser.parse_args()

	#check that mail is valid
	EMAIL_REGEX = re.compile(r"[^@]+@[^@]+\.[^@]+")
	if (args.new_mail is not None) and (not EMAIL_REGEX.match(args.new_mail)):
		print('Not a Valid Email')
		sys.exit()
	
	#ola kala proxwra se parapanw bimata to input sou einai swsto
	main(args.dbuser,args.database,args.password,args.existing,args.new_file,args.new_user,args.new_mail,args.new_file_name)