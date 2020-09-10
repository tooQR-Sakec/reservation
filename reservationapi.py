import json
import itertools
from flask import Flask, jsonify, request

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    if (request.method == 'POST'):
        some_json = request.get_json()
        tableInfo = dict(some_json)
        def capacity(noOfPeople, tableCombinations):
            for i in tableCombinations:
                if noOfPeople <= sum(list(i)):
                    return(list(i))
            return []
        def lowCapacity( noOfPeople):
            available = []
            minCapacityAll = []
            for i in table:
                
                available.append(table[i])

            totalTables = len(table)
            combination = 1
            while combination <= totalTables: 
                tableCombinations = list(itertools.combinations(available, combination))
                tableCombinations = sorted(tableCombinations, key=sum)
                minCapacity = capacity(noOfPeople, tableCombinations)
                minCapacityAll.append(minCapacity)
                combination += 1

            minCapacityAll = sorted(minCapacityAll, key=sum)
            for i in minCapacityAll:
                if i != []:
                    best_combination = i
                    break
            tablepair = []
            for i in best_combination:
                for j in table:
                    if i == table[j]:
                        tablepair.append(list(table.keys())[list(table.values()).index(i)])
                        table.pop(j,table[j])
                        break
            return tablepair
        def combineTable( noOfPeople):
            
            return lowCapacity(noOfPeople)
        noOfPeople = int(tableInfo.get("capacity"))
        table = {int(k):int(v) for k, v in tableInfo.get('table').items()}
        if (sum(list(table.values()))<noOfPeople):
            return 'False'
        return jsonify({"table combination":combineTable(noOfPeople)})

    else:
        return jsonify({'data':'none'})

if __name__ == "__main__":
    app.run(debug=True)
