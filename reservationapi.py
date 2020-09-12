import json
import itertools
from flask import Flask, jsonify, request

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    if (request.method == 'POST'):
        some_json = request.get_json() #accepts json from php json file contains
        tableInfo = dict(some_json) #json is converted into dictionary 
                                    # i.e. tableInfo = {'noOfPeople':'no of people specified by client','tables':{'tableID':'tableCapacity'}}
        
        def capacity(noOfPeople, tableCombinations):
            for i in tableCombinations:
                if noOfPeople <= sum(list(i)): # checking if combination of tables is possible according to the number of pepole
                    return(list(i))
            return [] # else returning empty list
        
        def lowCapacity( noOfPeople):
            available = []
            minCapacityAll = []
            for i in table:
                
                available.append(table[i]) # all the capacities of available tables are stored in list eg. [2,2,2,4]

            totalTables = len(table) 
            combination = 1
            while combination <= totalTables: 
                tableCombinations = list(itertools.combinations(available, combination)) #storing all the possible combinations of capacities 
                                                                                         #eg possible combinations of [2,2,4] are [2],[2],[4],[2,2],[2,4],[4,2],[2,2,4] 
                tableCombinations = sorted(tableCombinations, key=sum) # sorting all tablecombiantion with respect to sum
                minCapacity = capacity(noOfPeople, tableCombinations) # function capacity() is called and output is stored in mincapacity
                minCapacityAll.append(minCapacity) # making list of all possible combinations
                combination += 1

            minCapacityAll = sorted(minCapacityAll, key=sum) #sorting all the combinations
            for i in minCapacityAll:
                if i != []:
                    best_combination = i #removing empty lists
                    break
            tablepair = []
            for i in best_combination:
                for j in table:
                    if i == table[j]:
                        tablepair.append(list(table.keys())[list(table.values()).index(i)]) #fetching corresponding tableid of possible tablecapacities from the dictionary-table  
                        table.pop(j,table[j])
                        break
            return tablepair
        
        def combineTable(noOfPeople):
            return lowCapacity(noOfPeople) #calling function lowCapacity() and returning th output
        ######start######
        noOfPeople = int(tableInfo.get("capacity")) # algorithm will start from this line noOf people is assigned
        table = {int(k):int(v) for k, v in tableInfo.get('table').items()} #tableID and tableCapacity are converted from string to int
        
        if (sum(list(table.values()))<noOfPeople): # checking if number of people are greater than the maximum combination possible
            return 'False' 

        return jsonify(combineTable(noOfPeople)) #calling function combineTable() and converting the output in json format

    else:
        return jsonify({'data':'none'})

if __name__ == "__main__":
    app.run(debug=True)
