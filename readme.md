# Laravel Angular Seed
นี่คือ repo สำหรับ ตัวอย่างการเขียน laravel เพื่อเป็น backend ให้กับ Angular seed โดยเฉพาะสำหรับ [Phizaz's Angular Seed](https://github.com/phizaz/angular-seed)

# การติดตั้ง
การติดตั้ง Laravel สามารถอ่านได้จากเว็บไซต์ Laravel เอง แต่เนื่องจาก Laravel สามารถลงได้หลายวิธี (ในเว็บไซต์) ซึ่งในที่นี้ แนะนำให้ลงด้วย Vagrant เพราะว่าง่ายที่สุด และ Angular Seed ได้ config ไว้สำหรับอันนี้แล้ว (ไม่ต้องไปลง php, apache, mysql เอง)

สำหรับคนสงสัยว่า Vagrant คืออะไร ผู้เขียนเองก็ไม่ค่อยรู้เรื่องเหมือนกัน แต่บอกได้ว่ามันมีความใกล้เคึยงกับ Docker อยู่เหมือนกัน แต่คิดว่ากลุ่มลูกค้าจะไม่เหมือนกัน Vagrant ต้องการสร้าง environment สำหรับ Develop แต่ว่า Docker จะเน้นไปที่การสร้าง environment สำหรับ  Product มากกว่า ซึ่งทั้งสองทำหน้าที่คล้่าย ๆ ก็คือสร้าง isolate environment เพื่อให้เราสามารถติดตั้งโปรแกรมจำนวนมากได้ผ่านคำสั่งเดียว โดยไม่สำคัญว่าเครื่องที่ติดตั้งนั้นมีอะไรอยู่ก่อนหรือเปล่า

1. [โหลด และติดตั้ง VirtualBox](https://www.virtualbox.org/wiki/Downloads)
2. [โหลด และติดตั้ง Vagrant ](https://www.vagrantup.com/downloads.html)
3. โหลด package ต่าง ๆ ที่จำเป็นต้องใช้สำหรับ laravel ด้วยการใช้คำสั่ง `vagrant box add laravel/homestead` ซึ่งจะโหลดค่อนข้างนานเอาการ อันนี้ก็เหมือนแผ่น Windows ที่มีโปรแกรมมาพร้อมติดตั้งตอนลงเสร็จ
4. ลง [composer](https://getcomposer.org/) ซึ่งเป็น package manager ของ php ใช้สำหรับการลง Laravel ด้วย
4. ลง dependencies ต่าง ๆ ของ Laravel ด้วยการเรียก `composer install` อาจจะค่อนข้างนาน อย่าพึ่งท้อ หากเสร็จเรียบร้อยควรจะได้ folder `vendor` ที่มีข้อมูลข้างใน
5. geenrate config สำหรับ Vagrant บน Mac / Linux: ใช้ `php vendor/bin/homestead make` บน Windows: ใช้  `vendor\bin\homestead make` หลังจากนี้เราควรจะได้ไฟล์​ Vagrantfile และ Homestead.yaml ซึ่งจะเป็นไฟล์ config สำหรับ Vagrant ของเรา ซึ่งตอนแรกมักจะ config ให้ใช้แรมอย่างโหดสัส คือ 2048 MB เราอาจจะปรับลดลงให้เหลือซัก 1024 MB หรือ 512 MB
6. เรียก `vagrant up` เพื่อเร่ิม server ของเรา ครั้งแรกจะช้าหน่อย เพราะว่ามันจะต้องลงโปรแกรมให้ครบก่อน แต่ว่าครั้งต่อ ๆ ไปจะสั้นลง หลังจากนั้นเราจะสามารถเข้าใช้งานได้จาก `http://192.168.10.10` (ip อาจจะขึ้นอยู่กับแต่ละเครื่อง ดูได้ที่ `Homestead.yaml`)
7. config ให้เราสามารถเข้าผ่าน `http://homestead.app` โดยการเพิ่ม `192.168.10.10 homestead.app` ไปยัง `/etc/hosts` สำหรับ Mac และ Linux และไปยัง `C:\Windows\System32\drivers\etc\hosts` สำหรับ Windows
8. หากต้องการหยุด ให้เรียก `vagrant halt` (หากต้องการปิด virtual machine ข้อมูลทุกอย่างที่ไม่ได้ save จะหาย เหมือนปิดเครื่อง) `vagrant suspend` (เหมือนการ hibernate ซึ่งข้อมูลไม่หายแต่่ว่าจะไม่เป็นการปิดเครื่อง และเสียพื้นที่เล็กน้อยสำหรับจำ state) `vagrant destroy` (ลบ virtual machine ออกไปเลย ทำให้ครั้งแต่ไปจะ `vagrant up นาน` และข้อมูลที่ฝากไว้กับ virtual machine ก็จะหายหมด ไม่แนะนำ)
9. อย่าลืม copy ไฟล์ .env.example เป็น .env เพื่อ config สิ่งต่าง ๆ เช่น password ด้วย ซึ่งได้กำหนดค่าไว้สำหรับ mysql บน vagrant เรียบร้อยแล้ว
10. ตอนนี้ก็น่าจะเรียกเว็บได้ผ่าน `http://homestead.app` แล้ว และมีคำว่า **Laravel** ตัวโต ๆ อยู่ตรงกลาง

#[คู่มือการเขียนเว็บด้วย Laravel 5](http://laravel.com/docs)
