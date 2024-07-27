import React from "react"

export default function Counter(props) {
  const [count, setCount] = React.useState(props.initialCount ?? 0)

  return (
    <button
      className="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-200 text-black hover:bg-blue-200/90 h-10 px-4 py-2"
      onClick={() => setCount(v => v + 1)}
    >
      {count}
    </button>
  )
}
