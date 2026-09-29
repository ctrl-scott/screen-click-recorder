"use strict";

document.addEventListener("click", function (event) {

    const target = event.target;

    const clickData = {
        timestamp: new Date().toISOString(),

        pageX: event.pageX,
        pageY: event.pageY,

        clientX: event.clientX,
        clientY: event.clientY,

        screenX: event.screenX,
        screenY: event.screenY,

        element: target.tagName,
        id: target.id || "",

        className:
            typeof target.className === "string"
                ? target.className
                : ""
    };

    console.log(clickData);

    fetch("save-click.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(clickData)
    })
    .then(response => response.text())
    .then(result => {
        console.log("PHP:", result);
    })
    .catch(error => {
        console.error("Save error:", error);
    });

});
