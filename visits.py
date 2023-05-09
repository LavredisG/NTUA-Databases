#File to generate random datasets
import random
random.seed()
seen = set()

def double_dig(x):
    if(x<10):
        return "0"+str(x)
    else:
        return str(x)
    
for i in range(1,20):
    nfcid = i
    for j in range(15):
        entry_hour = random.randrange(24)
        entry_minutes = random.randrange(0,60)
        if((entry_hour<21) and (entry_hour != 0)):
            exit_hour = random.randrange(entry_hour,entry_hour+1)
        else:
            exit_hour = random.randrange(3)
        exit_minutes = random.randrange(entry_minutes,60)    
        entrance_time = double_dig(entry_hour)+":"+double_dig(entry_minutes)+":00"
        exit_time = double_dig(exit_hour)+":"+double_dig(exit_minutes)+":00"

        if(j%4==0):
            entry_day = 10
            entry_month = 6
        else:
            entry_day = random.randrange(1,28)
            entry_month = random.randrange(1,13)

        if(entry_month<=6):
            entry_year = 2021
        else:
            entry_year = 2020
            
        if((entry_hour< exit_hour) or ((entry_hour==exit_hour) and(entry_minutes<=exit_minutes))):
            exit_day = entry_day
        else:
            exit_day = entry_day+1

        entrance_date = str(entry_year)+"-"+double_dig(entry_month)+"-"+double_dig(entry_day)
        exit_date = str(entry_year)+"-"+double_dig(entry_month)+"-"+double_dig(exit_day)

        if(j%10 == 0):
            place_id = i+40
        else:
            place_id = random.randrange(1,40)
        
        if(nfcid, place_id, entrance_date)in seen:
            pass
        else:
            seen.add((nfcid, place_id, entrance_date))
            print("INSERT INTO visits(NFC_ID,Place_ID,Entrance_Time,Exit_Time,Entrance_Date,Exit_Date) values('",end='')
            print(nfcid, place_id, entrance_time, exit_time, entrance_date ,exit_date,sep="','",end='')
            print("');")

