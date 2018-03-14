import vcf
import mysql.connector
import sys,argparse
import collections

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

	#query: A TOMH B
def same_in_files(file1,file2):
	#apo mesa pros ta e3w: 
	#diale3e oles ta lines pou antistoixoun sta 2 files pou sou edwse o xristis
	#tsekare poia einai idia se position kai chromosoma kai girna mou ta
	query=(	"SELECT * FROM "
			"(SELECT * FROM VCF WHERE (file_id=%s))file1 "
			"INNER JOIN "
			"(SELECT * FROM VCF WHERE (file_id=%s))file2 "
			"ON file1.position=file2.position AND file1.chromosome=file2.chromosome"
		)
	return query

	#query: A-B
def diff_in_files_prwto(file1,file2):
	#apo mesa pros ta e3w: 
	#diale3e oles ta lines pou antistoixoun sta 2 files pou sou edwse o xristis
	#tsekare poia einai diaforetika se position kai chromosoma kai girna mou ta
	query=(	"SELECT * FROM "
			"(SELECT * FROM VCF WHERE (file_id=%s))file1 "
			"LEFT JOIN "
			"(SELECT * FROM VCF WHERE (file_id=%s))file2 "
			"ON file1.position=file2.position AND file1.chromosome=file2.chromosome "
			"WHERE file2.position IS NULL AND file2.chromosome IS NULL"
	)
	return query

	#query: B-A
def diff_in_files_deutero(file1,file2):
	#apo mesa pros ta e3w: 
	#diale3e oles ta lines pou antistoixoun sta 2 files pou sou edwse o xristis
	#tsekare poia einai diaforetika se position kai chromosoma kai girna mou ta
	query=(	"SELECT * FROM "
			"(SELECT * FROM VCF WHERE (file_id=%s))file1 "
			"RIGHT JOIN "
			"(SELECT * FROM VCF WHERE (file_id=%s))file2 "
			"ON file1.position=file2.position AND file1.chromosome=file2.chromosome "
			"WHERE file1.position IS NULL AND file1.chromosome IS NULL"
	)
	return query

def get_query(user,database,file1,file2,output_file,metadata,job_flag):
	cn = login_to_database(user,database)
	cursor = cn.cursor()

	#switch case replacement in python
	options = {
		0 : same_in_files,
        1 : diff_in_files_prwto,
		2 : diff_in_files_deutero,
	}
	query=options[job_flag](file1,file2)
	cursor.execute(query,(file1,file2))
		
	result=cursor.fetchall()
	commit_changes_close(cn,cursor)

	#HELPda
	#to vcf writer xreiazetai apo kapou na parei ta metadata gia na ta balei apo panw 
	#opote 8a tou dwsoume san input ena apo ta 2 arxeia
	vcf_reader = vcf.Reader(open(str(metadata), 'r'))
	vcf_writer = vcf.Writer(open(output_file, 'w'), vcf_reader)
	vcf_writer.close()
	#grapse to diko mas output sto input file
	#kanta named tuple https://pymotw.com/2/collections/namedtuple.html
	#gia na ta grapseis me to to vcf.Writer
	if (len(result)==0):
		print("None Found")
		return

	if (job_flag==0 or job_flag==1):
		for row in result:
			print (row[2:10])
	elif (job_flag==2):
		for row in result:
			print (row[12:len(row)])

	vcf_writer.close()
	return
	#END OF HELP

def main (dbuser,database,site_user,job,out_file,file1_name,file2_name,metadata):
	#prwta bres poio einai to user_id tou site_user pou sou esteile to commandline
	cn = login_to_database(dbuser,database)
	cursor = cn.cursor()
	user_site_id=0

	query=("SELECT user_id FROM USER WHERE username = %s ")
	cursor.execute(query,(site_user,))
	print('User Found')
	result=cursor.fetchall()
	commit_changes_close(cn,cursor)

	for row in result:
  		user_site_id = row[0]

	#meta pigaine sto table FILE kai bres poia einai ta file indexes 
	#pou antistoixoun sta onomata pou sou edwse autos o user

	cn = login_to_database(dbuser,database)
	cursor = cn.cursor()

	query=("SELECT file_id FROM FILE WHERE user_id = %s AND (file_name = %s OR file_name = %s)")
	cursor.execute(query,(user_site_id,str(file1_name),str(file2_name),))
	file1_index=cursor.fetchone()[0]
	file2_index=cursor.fetchone()[0]
	print('Files Found')
	commit_changes_close(cn,cursor)

	#diff_a bres diafores kai printare mou ta diaforetika snps apo to prwto arxeio
	#diff_a bres diafores kai printare mou ta diaforetika snps apo to deutero arxeio
	if (str(job)=="same"):		#query: A TOMH B

		print('Finding Same SNPs in files printing same from both files')
		get_query(dbuser,database,file1_index,file2_index,out_file,metadata,0)
	elif(str(job)=="diff_a"):	#query: A-B

		print('Finding Diff SNPs in files printing diff from file 1')
		get_query(dbuser,database,file1_index,file2_index,out_file,metadata,1)
	elif(str(job)=="diff_b"): 	#query: B-A
		print('Finding Diff SNPs in files printing diff from file 2')
		get_query(dbuser,database,file1_index,file2_index,out_file,metadata,2)
	elif(str(job)=="diff"): 	#query: (A-B)ENWSI(B-A)
		print('Finding Diff SNPs in files printing diff from both files')
		get_query(dbuser,database,file1_index,file2_index,out_file,metadata,1)
		get_query(dbuser,database,file1_index,file2_index,out_file,metadata,2)
	else:
		print("Wrong Job Command")

	print('Complete')


#command line gia na mporesei na pai3ei me to cron
if __name__ == '__main__':
	parser = argparse.ArgumentParser()
	parser.add_argument('--dbuser'		,dest='dbuser', 	action='store') # database administrator
	parser.add_argument('--db'			,dest='database', 	action='store') # database name
	parser.add_argument('--site_user'	,dest='user', 		action='store') #name of the site user
	parser.add_argument('--job'			,dest='job', 		action='store') #same||diff||diff_a||diff_b : ti eidous douleia 8eleis na kanei
	parser.add_argument('--out_file'	,dest='out_file', 	action='store') #name of the output file
	parser.add_argument('--file1'		,dest='file1', 		action='store') #site user given name of the 1st input file
	parser.add_argument('--file2'		,dest='file2', 		action='store') #site user given name of the 2nd input file
	parser.add_argument('--metadata'	,dest='metadata', 	action='store') #optional, ena path gia kapoio apo ta input files gia na paroume tis prwtes grammes pou exoun ta metadata
	args = parser.parse_args()

	
	#ola kala proxwra se parapanw bimata to input sou einai swsto
	main(args.dbuser,args.database,args.user,args.job,args.out_file,args.file1,args.file2,args.metadata)
