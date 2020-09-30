import json
import itertools
from flask import Flask, jsonify, request


def combinations(noOfPeople, table, tables):
    def capacity(noOfPeople, tableCombinations):
        caplist = []
        for i in tableCombinations:
            # checking if combination of tables is possible according to the number of pepole
            if noOfPeople <= sum(list(i)):
                if list(i) not in caplist:
                    caplist.append(list(i))
        return caplist

    def lowCapacity(noOfPeople):
        available = table
        minCapacityAll = []
        totalTables = len(table)
        combination = 1

        while combination <= totalTables:
            # storing all the possible combinations of capacities #eg possible combinations of [2,2,4] are [2],[2],[4],[2,2],[2,4],[4,2],[2,2,4]
            tableCombinations = list(
                itertools.combinations(available, combination))
            # sorting all tablecombiantion with respect to sum
            tableCombinations = sorted(tableCombinations, key=sum)
            # function capacity() is called and output is stored in mincapacity
            minCapacity = capacity(noOfPeople, tableCombinations)

            if minCapacity != []:
                # making list of all possible combinations
                minCapacityAll = minCapacityAll+minCapacity
            combination += 1

        # sorting all the combinations
        minCapacityAll = sorted(minCapacityAll, key=sum)
        # calling the adjacent function
        return findAdjacent(tables, minCapacityAll)

    # checking if number of people are greater than the maximum combination possible
    if (sum(table) < noOfPeople):
        return 'False'

    # calling function combineTable() and converting the output in json format
    return jsonify(lowCapacity(noOfPeople))


########## adjacent table algorithm ##########
def findAdjacent(tables, tableCombinations):
    def findAdjacentHelper(adjacentTables, tableCapacity):
        if tableCapacity == [] and adjacentTables != []:
            return solution

        elif adjacentTables == [] and tableCapacity != []:
            tableCapacity.append(
                tablesConsidered.get(solution[len(solution)-1]))
            tablesConsidered.pop(solution[len(solution)-1])
            rejected.append(solution.pop(len(solution)-1))
            if solution != []:
                adjacentTables = []
                adjacentTables += tables[solution[len(solution)-1]]['Adjacent']
                return findAdjacentHelper(adjacentTables, tableCapacity)

        elif adjacentTables[0] not in tables:
            adjacentTables.pop(0)
            return findAdjacentHelper(adjacentTables, tableCapacity)

        elif tables[adjacentTables[0]]['Capacity'] not in tableCapacity or adjacentTables[0] in solution or adjacentTables[0] in rejected or adjacentTables[0] in usedTables:
            adjacentTables.pop(0)
            return findAdjacentHelper(adjacentTables, tableCapacity)

        elif adjacentTables[0] not in solution and tables[adjacentTables[0]]['Capacity'] in tableCapacity:
            solution.append(adjacentTables[0])
            tablesConsidered.update(
                {adjacentTables[0]: tables[adjacentTables[0]]['Capacity']})
            tableCapacity.remove(tables[adjacentTables[0]]['Capacity'])
            adjacentTables = []
            adjacentTables += tables[solution[len(solution)-1]]['Adjacent']
            return findAdjacentHelper(adjacentTables, tableCapacity)

        else:
            return None

    usedTables = []
    finaltables = []

    for i in tableCombinations: 
    #checking for all the combinations to find a valid combiantion
        for firstTable in tables:
        # checking for every table
            solution = []
            rejected = []
            adjacentTables = []
            tableCapacity = []
            tablesConsidered = {}
            if i != []:
            #checking if the combination is not empty
                tableCapacity += i
                if tables[firstTable]['Capacity'] in tableCapacity and firstTable not in usedTables:
                    tablesConsidered.update(
                        {firstTable: tables[firstTable]['Capacity']})
                    tableCapacity.remove(tables[firstTable]['Capacity'])
                    solution.append(firstTable)
                    adjacentTables += tables[firstTable]['Adjacent']
                    if findAdjacentHelper(adjacentTables, tableCapacity):
                        usedTables += solution
                        finaltables.append(solution)
                        break
        if usedTables != []:
            break

    return finaltables


app = Flask(__name__)
@app.route('/', methods=['GET', 'POST'])
def index():
    if (request.method == 'POST'):
        some_json = request.get_json()  # accepts json from php json file contains
        # json is converted into dictionary # i.e. tableInfo = {'noOfPeople':'no of people specified by client','tables':{'tableID':'tableCapacity'}}
        tableInfo = dict(some_json)
        noOfPeople = int(tableInfo.get("capacity"))
        table = [int(v) for v in tableInfo.get('table')]
        tables = {int(k): v for k, v in (tableInfo.get("tables")).items()}
        return combinations(noOfPeople, table, tables)


if __name__ == "__main__":
    app.run(debug=True)

""" {"capacity": "6",
"table": [2, 2, 2, 2, 4],
"tables": {
    "1": {"Capacity": 2, "Adjacent": [2, 7]},
    "2": {"Capacity": 3, "Adjacent": [1, 8, 3]},
    "3": {"Capacity": 4, "Adjacent": [2, 9, 4]},
    "4": {"Capacity": 3, "Adjacent": [3, 10, 5]},
    "5": {"Capacity": 3, "Adjacent": [4, 11, 6]},
    "6": {"Capacity": 5, "Adjacent": [5, 12]},
    "7": {"Capacity": 2, "Adjacent": [1, 8]},
    "8": {"Capacity": 2, "Adjacent": [7, 2, 9, 13]},
    "9": {"Capacity": 2, "Adjacent": [8, 3, 10, 14]},
    "10": {"Capacity": 3, "Adjacent": [4, 9, 11, 15]},
    "11": {"Capacity": 3, "Adjacent": [10, 5, 12, 16]},
    "12": {"Capacity": 5, "Adjacent": [6, 11]},
    "13": {"Capacity": 3, "Adjacent": [8, 14]},
    "14": {"Capacity": 2, "Adjacent": [13, 9, 15]},
    "15": {"Capacity": 3, "Adjacent": [14, 10, 16]},
 } """
