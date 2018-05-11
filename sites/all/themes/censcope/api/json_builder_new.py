import sys

def chart_pie(labels, dataset, colors):
    """
    Returns a string that represents a JSON object for a pie chart
    constructed from the dataset provided.
    labels: a list of strings for the names of each slice
    dataset: a list of values for each slice
    colors: a list of (r, g, b, a) tuples for each slice
    Labels and data are matched up by index; for example dataset[0]
    and labels[0] will be attributes of the same slice.
    """

    #create a list of colors that is the appropriate length
    newColors = []
    for i in range(len(dataset)):
        newColors.append(colors[i%len(colors)])
    colors = newColors
    
    j = '{'
    j += '"type": \"pie\", "data": '
    j += "{"
    j += '"labels": ['
    for label in labels:
        label = label.replace(",", "")
        j+= '"' + label.decode('utf-8') + '"'
        if label != labels[-1]:
            j += ','
    j += '], '

    j += '"datasets": ['
    j += '{"data": ['

    for data in dataset:
            
        if (data is None) or (len(data)==0):
            data = '0' 

        j+= str(data)

        if data != dataset[-1]:
            j += ","
    j += "]"

    j += ", "
    j += '"backgroundColor": ['

    for color in colors[:-1]:
        j += '"'
        j += str(color)
        j += '\",'
    j += '\"'+colors[-1]+'"';

    j += "],"
    j += '"hoverBackgroundColor": ['

    for color in colors[:-1]:
        j += '"'
        j += str(color)
        j += '\",'
    j += '\"'+colors[-1]+'"';

    j += "]}"
    j += "]},"
    j += '"options": {"animation": { "duration": 1000, "animateRotate": false,'
    j += '"animateScale": true}'
    j += '} }'
    return j

def chart_bar(axislabels, setlabels, datasets, colors):
    """
    Returns a string that represents the JSON object for a stacked
    bar chart constructed from the datasets provided.
    axislabels: a list of strings for the x-axis labels on the chart
    setlabels: a list of strings, one label for each dataset
    datasets: a list of lists of numerical values to plot
    """

    #create a list of colors that is the appropriate length
    newColors = []
    for i in range(len(datasets)):
        newColors.append(colors[i%len(colors)])
    colors = newColors

    j = '{'
    j += '"type": \"bar\", "data":'
    j += "{"
    j += '"labels":[ '
    for l in axislabels:
        j += '"' + l + '"'
        if l != axislabels[-1]:
            j += ","
    j += '], "datasets": ['

    for i in range(len(datasets)):
        j += "{"
        j += '"type": \"bar\",'
        j += '"label": \"'
        j += str(setlabels[i])
        #j += '\", "backgroundColor":"' + colors[i] + '"'
        j += '\", "backgroundColor":[\"#FF6384\",\"#36A2EB\"]'
        
        
        j += ', "data": ['

        for d in datasets[i]:
            j += str(d)

            if d != datasets[i][-1]:
                j += ","
        if i != len(datasets) - 1:
            j += "]},"
        else:
            j += "]}"

    j += "]}"
    j += ','
    j += '"options": { "scales": { "xAxes": [{"stacked": true}],'
    j += '"yAxes": [{"stacked": true }] } } }'

    return j

def chart_line(axislabels, setlabels, datasets, colors):
    """
    Returns a string representing the JSON object for a line chart
    constructed from the datasets provided.
    axislabels: a list of strings for the x-axis labels on the chart
    datasets: a list of lists of numerical values to plot, each list is for one line
    setlabels: a list of strings, one for each line
    """

    #create a list of colors that is the appropriate length
    newColors = []
    for i in range(len(datasets)):
        newColors.append(colors[i%len(colors)])
    colors = newColors

    j = '{'
    j += '"type": \"line\", "data": '
    j += "{"
    j += '"labels": ['
    #j += str(axislabels)
    for i in range(len(axislabels)):
        j += str(axislabels[i])
        if not (i == len(axislabels) - 1):
            j += ','
    j += '], "datasets": ['
    for i in range(0,len(datasets)):
        j += "{"
        j += '"label": \"'
        j += setlabels[i]
        j += '\", "backgroundColor":"' + colors[i] + '"'
        j += ', "borderColor":"' + colors[i] + '"'
        j += ', "fill": false, "data": ['
        #j += str(datasets[i])
        for d in range(len(datasets[i])):
            j += str(datasets[i][d])
            if not (d == len(datasets[i]) - 1):
                j += ','
        j += "]}"

        if i != len(datasets) - 1:
            j += ","

    j += "]},"
    j += '"options": {"title": { "display": true, "text": \"Line Chart\"}, "scales": {"yAxes": [{"ticks":{ "beginAtZero": true}}]}}}'
    return j


def chart_popPyramid(axislabels, setlabels, dataset1, dataset2, colors):
    """
    Returns a string representing the JSON object for a population pyramid chart.
    axislabels: a list of strings for the long axis on the chart
    setlabels: a list containing 2 strings; one for each dataset (e.g. ['male', 'female'])
    dataset1: a list of numerical values representing one dataset for the chart
    dataset2: a list of numerical values representing the other dataset
    colors: a list of 2 RGBA colors, one to color each dataset
    """

    #create a list of colors that is the appropriate length
    newColors = [colors[0], colors[1]]
    colors = newColors
    
    #make one dataset negative to display properly
    tmp = list()
    for num in dataset1:
        tmp.append(num * -1)

    datasets1 = tmp

    j = '{'
    j += '"type": "horizontalBar", "data": '
    j += '{'
    j += '"labels": ['
    for label in axislabels:
        j += '"' + label + '"'
        if label != axislabels[-1]:
            j += ","
    j += '], "datasets": ['

    j += "{"
    j += '"label": "'
    j += setlabels[0]
    j += '\", "backgroundColor":"' + colors[0] + '"'
    j += ', "data": ['

    for d in dataset1:
        j += str(d)
        if d != dataset1[-1]:
            j += ","
    j += "]}"

    j += ","

    j += "{"
    j += '"label": "'
    j += setlabels[1]
    j += '\", "backgroundColor":"' + colors[1] + '"'
    j += ', "data": ['

    for d in dataset2:
        j += str(d)
        if d != dataset2[-1]:
            j += ","
    j += "]}"

    j += "]}}"
    
    return j


def main(args):
    func = args[1]
    color_list = ["#FF6384",
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
    if (func == 'pie'):
        #example: pie red,white,blue 30,45,25
        if not (len(args) == 4):
            print('Error in json_builder.py: pie chart requires 2 lists as arguments')
            return
        else:
            labels = args[2].split(',')
            dataset = args[3].split(',')
            return chart_pie(labels, dataset, color_list)

    if (func == 'bar'):
        #example: bar 1,2,3,4,5 chips,dip 2,3,4,5,6&4,3,2,1,0
        #the third argument must be a list of lists
        #   lists should be separated by '&'
        #   elements within lists are separated by ','
        if not (len(args) == 5):
            print('Error in json_builder.py: bar chart requires 3 lists as arguments')
            return
        else:
            print(args)
            axislabels = args[2].split(',') # x-axis
            setlabels = args[3].split(',')
            setlist = args[4].split('&')
            print("4 " + args[4])
            datasets = []
            for s in setlist:
                l = s.split(',')
                datasets.append(l)
            print(datasets)
            return chart_bar(axislabels, setlabels, datasets, color_list)

    if (func == 'line'):
        #example: line 1;2;3;4;5 chips;dip 2;3;4;5;6&4;3;2;1;0
        #the third argument must be a list of lists
        #   lists should be separated by '&'
        #   elements within lists are separated by ';'
        if not (len(args) == 5):
            print('Error in json_builder.py: line chart requires 3 lists as arguments')
            return
        else:
            axislabels = args[2].split(';')
            setlabels = args[3].split(';')
            setlist = args[4].split('&')
            datasets = []
            for s in setlist:
                l = s.split(';')
                datasets.append(l)
            return chart_line(axislabels, setlabels, datasets, color_list)

    if (func == 'pyramid'):
        #example: pyramid 1,2,3,4,5 male,female 1,2,3,4,5 62,72,82,92,10
        if not (len(args) == 6):
            print('Error in json_builder.py: line chart requires 4 lists as arguments')
            return
        else:
            axislabels = args[2].split(',')
            setlabels = args[3].split(',')
            list1 = args[4].split(',')
            list2 = args[5].split(',')
            return chart_popPyramid(axislabels, setlabels, list1, list2, color_list)
        
    return

print(main(sys.argv))





    
