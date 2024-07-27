import React from "react"
import ReactDOM from "react-dom/server"

const App = require(process.argv[2]).default
const data = JSON.parse(process.argv[3])
const html = ReactDOM.renderToString(<App {...data} />)
console.log(html)
