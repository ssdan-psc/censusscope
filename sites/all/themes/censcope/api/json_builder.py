
class Dataset(object):
    def __init__(self, type_name):
        self.type_name = type_name
        return

class Pie_Slices(Dataset):
    """
    Object for building pie chart JSONs. Every dataset in a pie chart
    should be a pie_slices object. pie_slices contain:
        colors: a list of (r, g, b, a) tuples for each slice
        dataset: a list of values for each slice
    Each slice has one color associated with it, as well
    as its data. Corresponding values are matched by index. This means
    that colors[0], and dataset[0] correspond to the
    same slice of the pie chart.
    """
    def __init__(self, colors, data):
        super(Pie_Slices, self).__init__("pie")
        self.colors = colors
        self.data = data

class Stacked_Bars(Dataset):
    """
    Object for building stacked bar chart JSONs. Every dataset in a
    stacked bar chart should be a stacked_bars object. stacked_bars
    contain:
        label: a string for the name of the data set
        color: (r, g, b, a) tuple representing the set's color
        data: a list of nuerical values for each bar
    All bars in the dataset are the same color and have the same
    label. The values should be of a numerical type.
    """
    def __init__(self, label, color, data):
        super(Stacked_Bars, self).__init__("bars")
        self.label = label
        self.color = color
        self.data = data

class Line_Data(Dataset):
    """
    Object for building line chart JSONs. Every dataset in a line chart
    should be a line_data object. line_data contains:
        label: a string for the name of the data set
        data: list of numerical values for each point on the line
    """
    def __init__(self, data, label, color):
        super(Line_Data, self).__init__("line")
        self.label = label
        self.data = data
        self.color = color


def chart_pie(labels, dataset):
    """
    Returns a string that represents a JSON object for a pie chart
    constructed from the dataset provided.
    labels: a list of strings for the names of each slice
    dataset: a pie_slices object that represents the set
                of data displayed in this pie chart
    Labels aand data are matched up by index; for example dataset[0]
    and labels[0] will be attributes of the same slice.
    """

    j = '{'
    j += '"type": \"pie\", "data": '
    j += "{"
    j += '"labels": ['
    for label in labels:
        j+= '"' + label.decode('utf-8') + '"'
        if label != labels[-1]:
            j += ','
    j += '], '

    j += '"datasets": ['
    j += '{"data": ['

    for data in dataset.data:
        j+= str(data)

        if data != dataset.data[-1]:
            j += ","
    j += "]"

    j += ", "
    j += '"backgroundColor": ['

    for color in dataset.colors:
        j += '"'
        j += str(color)

        if color != dataset.colors[-1]:
            j += "\","
        else:
            j += '"'

    j += "],"
    j += '"hoverBackgroundColor": ['

    for color in dataset.colors:
        j += '"'
        j += str(color)

        if color != dataset.colors[-1]:
            j += "\","
        else:
            j += '"'

    j += "]}"
    j += "]},"
    j += '"options": {"animation": { "duration": 1000, "animateRotate": false,'
    j += '"animateScale": true}'
    j += '} }'
    return j

def chart_bar(labels, datasets):
    """
    Returns a string that represents the JSON object for a stacked
    bar chart constructed from the datasets provided.
    labels: a list of strings for the x-axis labels on the chart
    datasets: a list of stacked_bars objects, one for each dataset
    """

    j = '{'
    j += '"type": \"bar\", "data":'
    j += "{"
    j += '"labels": '
    j += str(labels)
    j += ', "datasets": ['

    for bars in datasets:
        j += "{"
        j += '"type": \"bar\",'
        j += '"label": \"'
        j += str(bars.label)
        j += '\", "backgroundColor":"' + bars.color + '"'
        j += ', "data": ['

        for d in bars.data:
            j += str(d)

            if d != bars.data[-1]:
                j += ","
        if bars != datasets[-1]:
            j += "]},"
        else:
            j += "]}"

    j += "]}"
    j += ','
    j += '"options": { "scales": { "xAxes": [{"stacked": true}],'
    j += '"yAxes": [{"stacked": true }] } } }'

    return j


def chart_line(labels, datasets):
    """
    Returns a string representing the JSON object for a line chart
    constructed from the datasets provided.
    labels: a list of strings for the x-axis labels on the chart
    datasets: a list of line_data objects, one for each dataset
    """

    j = '{'
    j += '"type": \"line\", "data": '
    j += "{"
    j += '"labels": '
    j += str(labels)
    j += ', "datasets": ['
    for lines in datasets:
        j += "{"
        j += '"label": \"'
        j += lines.label
        j += '\", "backgroundColor":"' + lines.color + '"'
        j += ', "borderColor":"' + lines.color + '"'
        j += ', "fill": false, "data": '
        j += str(lines.data)
        j += "}"

        if lines != datasets[-1]:
            j += ","

    j += "]},"
    j += '"options": {"title": { "display": true, "text": \"Line Chart\"}, "scales": {"yAxes": [{"ticks":{ "beginAtZero": true}}]}}}'
    return j

def chart_popPyramid(labels, datasets):
    """
    Returns a string representing the JSON object for a population pyramid
    (horizontal histogram) constructed from the datasets provided.
    labels: a list of strings for the x-axis labels on the chart
    datasets: a list of stacked_bars objects, one for each dataset

    This function can be called with stacked_bars objects, just like
    chart_bar().
    The list of stacked_bars objects passed in as datasets should contain
    exactly two elements.
    """
    # Make the first dataset negative in order to display properly
    tmp = list()
    for num in datasets[0].data:
        tmp.append(num * -1)

    datasets[0].data = tmp

    j = '{'
    j += '"type": "horizontalBar", "data": '
    j += '{'
    j += '"labels": ['
    for label in labels:
        j += '"' + label + '"'
        if label != labels[-1]:
            j += ","
    j += '], "datasets": ['

    for bars in datasets:
        j += "{"
        j += '"label": "'
        j += bars.label
        j += '\", "backgroundColor":"' + bars.color + '"'
        j += ', "data": ['

        for d in bars.data:
            j += str(d)
            if d != bars.data[-1]:
                j += ","
        j += "]}"

        if bars != datasets[-1]:
            j += ","

    j += "]}}"
    return j


def build_json(labels, datasets):
    """
    Returns a string representing the JSON object for the chart
    matching the datasets passed in.
    labels: a list of strings representing the labels in the chart
    datasets: a dataset object or list of dataset objects holding
                the data for this chart
    To make a pie chart, pass in a list containing a single
    pie_slices object. For other charts, pass in a list of 
    dataset objects. To make a chart with only one set of data,
    pass a list with only one dataset object. All the dataset
    objects in the list must be of the same subtype of
    dataset.
    """
    if (datasets[0].type_name == "pie"):
        return chart_pie(labels, datasets[0])
    elif (datasets[0].type_name == "bars"):
        return chart_bar(labels, datasets)
    elif (datasets[0].type_name == "line"):
        return chart_line(labels, datasets)

    return


def test():
    labels = [0, 1, 2, 3, 4, 5]
    data = []
    data.append(Line_Data([10, 20, 30, 40, 35, 25], "cows"))
    data.append(Line_Data([1, 2, 3, 4, 3.5, 2.5], "chickens"))
    j = chart_line(labels, data)

    file = open('json.txt', 'w')
    file.write(str(j))
    file.close()
    print(j)
    return
