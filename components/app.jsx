import React, { useState } from "react"
import Counter from "./counter"

export default function App(props) {
  const [greeting, setGreeting] = useState("hello")
  return (
    <>
      <div className="py-4 max-w-md space-y-2">
        <input
          className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          value={greeting}
          onChange={e => setGreeting(e.target.value)}
        />
        <div>
          {greeting}, {props.who}
        </div>
      </div>

      <Counter {...props} />
      {props.children}
    </>
  )
}
