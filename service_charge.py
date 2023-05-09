#File to generate random datasets
import random
random.seed()
seen = set()

goods=[["coca cola","beer","cocktail","coffee","lemonade","ice tea","sprite"],["steak","lasagna","hamburger","pepsi","happy meal","fish fillet","filet mignon"],["balayage","hairstyle","haircut"],["workout"],["sauna"],["conference"]]
charges=[[3,5,10,4,3,3,3],[15,10,13,3,9,14,30],[20,15,30],[10],[50],[300]]
def double_dig(x):
    if(x<10):
        return "0"+str(x)
    else:
        return str(x)   

def calc_charge(x):
    if (x==1 or x==2):
        good1=random.randrange(7)
        good2=random.randrange(7)
        good1quant=random.randrange(1,4)
        good2quant=random.randrange(1,4)
        if good1==good2:
            charge_str = str(good1quant)+" "+goods[x-1][good1]
            charge = charges[x-1][good1]*good1quant
        else:    
            charge_str = str(good1quant)+" "+goods[x-1][good1]+" + "+str(good2quant)+" "+goods[x-1][good2]
            charge = (charges[x-1][good1]*good1quant)+(charges[x-1][good2]*good2quant)
    elif(x==3):
        good=random.randrange(3)
        charge_str = "1 "+goods[x-1][good]
        charge = charges[x-1][good]
    else:
        charge_str = charge_st = "1 "+goods[x-1][0]
        charge = charges[x-1][0]
        
    return (charge_str,charge)
        
for i in range(1,20):
    nfcid = i
    for j in range(51):
        service_id=random.randrange(1,7)
        entry_hour = random.randrange(24)
        entry_minutes = random.randrange(0,59)  
        entrance_time = double_dig(entry_hour)+":"+double_dig(entry_minutes)+":00"

        charge_str, charge = calc_charge(service_id)
        entry_day = random.randrange(1,28)
        entry_month = random.randrange(1,13)
        if(entry_month<=6):
            entry_year = 2021
        else:
            entry_year = 2020
            
        entrance_date = str(entry_year)+"-"+double_dig(entry_month)+"-"+double_dig(entry_day)

        if(nfcid, service_id, entrance_time)in seen:
            pass
        else:
            seen.add((nfcid, service_id, entrance_time))
            print("INSERT INTO service_charge(NFC_ID,Service_ID,Charge_Desc,Charge_Price,Charge_Date,Charge_Time) values('",end='')
            print(nfcid, service_id, charge_str, charge, entrance_date,entrance_time,sep="','",end='')
            print("');")
