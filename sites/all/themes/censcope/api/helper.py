
def get_cols(topic, cursor, chart):
    query = "SELECT col, label FROM col_map WHERE topic=" + "'" + topic + "' AND " + chart + "= 1"
    cursor.execute(query)
    results = cursor.fetchall()
    cols = []
    labels = []
    for c in results:
        col = c[0].decode('utf-8')
        label = c[1].decode('utf-8')
        cols.append(col)
        labels.append(label)
    return cols, labels