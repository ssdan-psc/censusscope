from flask import Flask, jsonify, request, make_response
from flaskext.mysql import MySQL
from flask_cors import CORS, cross_origin
import json
import io 
import csv 

from helper import get_cols
import json_builder

app = Flask(__name__)
CORS(app)

mysql = MySQL()

# TODO: Use config file to set these
# MySQL Configurations
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = ''
app.config['MYSQL_DATABASE_DB'] = 'census_scope'
app.config['MYSQL_DATABASE_HOST'] = 'localhost'
app.config['MYSQL_DATABASE_PORT'] = 3307
mysql.init_app(app)

conn = mysql.connect()
cursor = conn.cursor()

TABLE = 'sample'
    
# TODO: Change colors?
colors = ["#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362",
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#cb62ff",
          "#72ff62",
          "#ffa362"]

# TODO: Be careful about bytes coming from SQL queries 

@app.route('/')
@cross_origin()
def index():
    return "Hello, World!"

# /trend?geo=GEO&topic=TOPIC
@app.route('/trend', methods=['GET'])
@cross_origin()
def get_trend_chart():
    geo = request.args.get('geo')   # TODO: Map geo to all possible geos
    topic = request.args.get('topic')		

    cols, data_labels = get_cols(topic, cursor, 'trend')
    
    if cols:
        query = "SELECT Year"
        data_labels.insert(0, 'Year')
        for col in cols: 
            query += "," + col.decode('utf-8')
        query += " FROM "  + TABLE + " WHERE AreaName='" + geo + "'"

        cursor.execute(query)
        results = cursor.fetchall()

        labels = []
        data = []
        for result in results:
            labels.append(result[0])
            data.append(result[1])
      
        response = {}
        chart = json_builder.chart_line(labels, [json_builder.Line_Data(data, data_labels[1], colors[0])])
        response["chart"] = json.loads(chart)
        with io.BytesIO() as csv_string:
            writer = csv.writer(csv_string)
            writer.writerow(data_labels)
            for row in results: 
                writer.writerow(row)

            response["csv"] = csv_string.getvalue()


        return json.dumps(response)

    else:
        return make_response("%s is an invalid topic" % (topic), 400)


# /pie?geo=GEO&topic=TOPIC&year=YEAR
@app.route('/pie', methods=['GET'])     
@cross_origin()
def get_pie_chart():
    geo = request.args.get('geo')   # TODO: Map geo to all possible geos 
    topic = request.args.get('topic')
    year = request.args.get('year')

    # TODO: Must have year

    cols, labels = get_cols(topic, cursor, 'pie')

    if cols:
        query = "SELECT "
        for col in cols:
            query += col.decode('utf-8')
            if col != cols[-1]:
                query += ","

        query += " FROM " + TABLE + " WHERE AreaName='" + geo + "' AND Year=" + year

        try:
            cursor.execute(query)
        except:
            return make_response("%s is invalid" % (query), 400)
        
        results = cursor.fetchall()

        if not results:
            return make_response("There is no data available for %s in %s in %s" % (topic, geo, year), 400)
        
        data = results[0]
    
        dataset = json_builder.Pie_Slices(colors[:len(data)], data)

        response = {}
        chart = json_builder.chart_pie(labels, dataset)
        response['chart'] = json.loads(chart)

        csv1 = ''
        csv1 += ','.join(labels) + '\n'
        for row in results:
             csv1 += ', '.join(str(x) for x in row) + '\n'

        response["csv"] = csv1
        return json.dumps(response)

    else:
        return make_response("%s is an invalid topic" % (topic), 400)

# /stacked?topic=TOPIC&geo=GEO
@app.route('/stacked', methods=['GET'])
@cross_origin()
def get_stacked_chart():
    geo = request.args.get('geo')   # TODO: Map geo to all possible geos
    topic = request.args.get('topic')       

    cols, data_labels = get_cols(topic, cursor, 'stacked_bar')

    if cols:
        query = "SELECT Year"
        for col in cols: 
            query += "," + col.decode('utf-8')
        query += " FROM "  + TABLE + " WHERE AreaName='" + geo + "'"

        cursor.execute(query)
        results = cursor.fetchall()

        labels = []
        data = []
        temp = []
        for result in results:
            labels.append(result[0])
            for i in range(1, len(result)):
                if result == results[0]:
                    temp.append([result[i]])
                else:
                    temp[i - 1].append(result[i])

        for i in range(0, len(temp)):
            dataset = json_builder.Stacked_Bars(data_labels[i], colors[i], temp[i])

            data.append(dataset)

        csv = ''
        csv += 'Year,' + ','.join(cols) + '\n'
        for i in range(0, len(labels)):
            csv += str(labels[i]) + ',' # Year
            for j in range(0, len(temp)):
                csv += str(temp[j][i])
                if j != len(temp) - 1:
                    csv += ','
            csv += '\n'

        response = {}
        chart = json_builder.chart_bar(labels, data)
        response["chart"] = json.loads(chart)
        response['csv'] = csv

        return json.dumps(response)

    else:
        return make_response("%s is an invalid topic" % (topic), 400)


# /table?topic=TOPIC&geo=GEO
@app.route('/table', methods=['GET'])
@cross_origin()
def get_table():
    topic = request.args.get('topic')
    geo = request.args.get('geo')

    cols, labels = get_cols(topic, cursor, "tbl")

    if cols:
        query = "SELECT Year,"
        labels.insert(0, "Year")
        for col in cols: 
            query += col.decode('utf-8')
            if col != cols[-1]:
                query += ","
        query += " FROM "  + TABLE + " WHERE AreaName = '" + geo + "'"

        cursor.execute(query)
        results = cursor.fetchall()

        with io.BytesIO() as csv_string:
            writer = csv.writer(csv_string)
            writer.writerow(labels)
            for row in results: 
                writer.writerow(row)

            return json.dumps(csv_string.getvalue())

    else:   
        return make_response("%s is an invalid topic" % (topic), 400)


# /pyramid?topic=TOPIB&geo=GEO
@app.route('/pyramid', methods=['GET'])
@cross_origin()
def get_pyramid():
    topic = request.args.get('topic')
    geo = request.args.get('geo')

    cols1, data_labels1 = get_cols(topic, cursor, "pyramid1")
    cols2, data_labels2 = get_cols(topic, cursor, "pyramid2")

    # TODO: Verify data_labels1 == data_labels2

    if cols1 and cols2:
        query1 = "SELECT "
        for col in cols1:
            query1 += col.decode('utf-8')
            if col != cols1[-1]:
                query1 += ","
        query1 += " FROM " + "popPyramid2014_15" + " WHERE Name = '" + geo + "'"

        cursor.execute(query1)
        results1 = cursor.fetchall()

        query2 = "SELECT "
        for col in cols2:
            query2 += col.decode('utf-8')
            if col != cols2[-1]:
                query2 += ","
        query2 += " FROM " + "popPyramid2014_15" + " WHERE Name = '" + geo + "'"

        cursor.execute(query2)
        results2 = cursor.fetchall()    

        # Male & Female labels are hardcoded
        dataset1 = json_builder.Stacked_Bars("Male", colors[0], results1[0][::-1])
        dataset2 = json_builder.Stacked_Bars("Female", colors[1], results2[0][::-1])


        labels = [label.encode('utf-8') for label in data_labels1][::-1]

        chart = json_builder.chart_popPyramid(labels, [dataset1, dataset2])    # Called with Stacked Bars object

        csv = ''
        csv += 'Sex, ' + ','.join(data_labels1) + '\\n'
        csv += 'Male, ' + ', '.join(str(x) for x in results1[0]) + '\n'
        csv += 'Female, ' + ', '.join(str(x) for x in results2[0]) + '\n'

        response = {}
        response['csv'] = csv
        response["chart"] = json.loads(chart)
        return json.dumps(response)
    else:
        return make_response("%s is an invalid topic" % (topic), 400)


if __name__ == '__main__':
    app.run(debug=True)
