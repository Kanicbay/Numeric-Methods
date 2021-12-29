<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>math.js | plot</title>
  <script src="https://unpkg.com/mathjs@10.0.1/lib/browser/math.js"></script>

  <script src="https://cdn.plot.ly/plotly-1.35.2.min.js"></script>

  <style>
    input[type=text] {
      width: 300px;
    }
    input {
      padding: 6px;
    }
    body, html, input {
      font-family: sans-serif;
      font-size: 11pt;

    }
    form {
      margin: 20px 0;
    }
  </style>
</head>
<body>

<form id="form">
  <label for="eq">Enter an equation:</label>
  <input type="text" id="eq" value="4 * sin(x) + 5 * cos(x/2)" />
  <input type="submit" value="Draw" />
</form>

<div id="plot"></div>

<p>
  Used plot library: <a href="https://plot.ly/javascript/">Plotly</a>
</p>

<script>
  function draw() {
    try {
      // compile the expression once
      const expression = document.getElementById('eq').value
      const expr = math.compile(expression)

      // evaluate the expression repeatedly for different values of x
      const xValues = math.range(-10, 10, 0.5).toArray()
      const yValues = xValues.map(function (x) {
        return expr.evaluate({x: x})
      })

      // render the plot using plotly
      const trace1 = {
        x: xValues,
        y: yValues,
        type: 'scatter'
      }
      const data = [trace1]
      Plotly.newPlot('plot', data)
    }
    catch (err) {
      console.error(err)
      alert(err)
    }
  }

  document.getElementById('form').onsubmit = function (event) {
    event.preventDefault()
    draw()
  }

  draw()
</script>

</body>
</html>