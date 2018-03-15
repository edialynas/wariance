#after installing the necessary mods
#teminal sindesi stin database kai meta ta command tou database_create.txt
#kai meta ta apo katw

python2 vcf_read.py --dbuser antonios  --db dialisi --new_user antonios --p 1234 --new_mail antokioukis@gmail.com --new_file_name atest1 --new_file_path /home/antonios/Downloads/danio_rerio.vcf
python2 vcf_read.py --dbuser antonios  --db dialisi --existing antonios --new_file_name atest2 --new_file_path /home/antonios/Downloads/danio_rerio.vcf

python2 vcf_read.py --dbuser antonios  --db dialisi --new_user kleiw --p 4321 --new_mail kleiwberrou@hotmail.com --new_file_name ktest1 --new_file_path /home/antonios/Downloads/danio_rerio.vcf
python2 vcf_read.py --dbuser antonios  --db dialisi --existing kleiw --new_file_name ktest2 --new_file_path /home/antonios/Downloads/danio_rerio.vcf

python2 vcf_write.py --dbuser antonios --db dialisi --site_user antonios --job same --out_file atest.txt --file1 atest1 --file2 atest2 --metadata /home/antonios/Downloads/danio_rerio.vcf
python2 vcf_write.py --dbuser antonios --db dialisi --site_user kleiw    --job diff --out_file ktest.txt --file1 ktest1 --file2 ktest2 --metadata /home/antonios/Downloads/danio_rerio.vcf