$(document).ready(function () {
  // Function to update productivity
  function updateProductivity() {
    $.ajax({
      url: "/task-productivity-tracker/php/api/productivity.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        displayProductivity(data);
        displayProductivityBottom(data); // Call new function to update bottom section
      },
      error: function (xhr, status, error) {
        console.error("Error fetching productivity:", status, error);
        $("#global-message").html(
          "<div class='alert alert-danger'>Failed to load productivity data.</div>"
        );
      },
    });
  }

  // Function to display productivity in popup
  function displayProductivity(data) {
    let productivityPopup = $("#productivityPopup");
    // Check if the element exists before trying to manipulate it.
    if (!productivityPopup.length) {
      // If #productivityPopup does not exist, create it.  Crucial:  Create it only once.
      productivityPopup = $(
        '<div id="productivityPopup" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">' +
          '  <div class="modal-dialog" role="document">' +
          '    <div class="modal-content">' +
          '      <div class="modal-header">' +
          '        <h5 class="modal-title">Productivity Data</h5>' +
          '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
          '          <span aria-hidden="true">&times;</span>' +
          "        </button>" +
          "      </div>" +
          '      <div id="productivityList" class="modal-body">' +
          "      </div>" +
          '      <div class="modal-footer">' +
          '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
          "      </div>" +
          "    </div>" +
          "  </div>" +
          "</div>"
      );
      $("body").append(productivityPopup); // Append to the body *once*
    }

    let productivityList = $("#productivityList");
    productivityList.empty();
    if (data) {
      let summaryItem = $("<li class='list-group-item'></li>").html(
        "<b>Completed Tasks:</b> " +
          data.completedTasks +
          " / " +
          data.totalTasks +
          " (" +
          data.productivityPercentage +
          "%)"
      );
      productivityList.append(summaryItem);

      if (data.completionTimes && data.completionTimes.length > 0) {
        let completionHeader = $("<li class='list-group-item'></li>").html(
          "<b>Completion Times</b>"
        );
        productivityList.append(completionHeader);
        $.each(data.completionTimes, function (index, item) {
          let taskItem = $("<li class='list-group-item'></li>").html(
            "<b>Task:</b> " +
              item.name +
              ", <b>Completed on:</b> " +
              item.completion_time
          );
          productivityList.append(taskItem);
        });
      }
    } else {
      productivityList.html(
        "<li class='list-group-item'>No productivity data available.</li>"
      );
    }
    // Show the popup
    if (showPopup) {
      $("#productivityPopup").modal("show");
    }
  }

  // Function to display productivity in bottom section
  function displayProductivityBottom(data) {
    let productivityBottom = $("#productivitySummary"); // Select the element with ID productivitySummary
    if (productivityBottom.length) {
      productivityBottom.empty(); // Clear previous content

      let summaryItem = $("<p></p>").html(
        // Use paragraph for bottom section
        "<b>Completed Tasks:</b> " +
          data.completedTasks +
          " / " +
          data.totalTasks +
          " (" +
          data.productivityPercentage +
          "%)"
      );
      productivityBottom.append(summaryItem);

      if (data.completionTimes && data.completionTimes.length > 0) {
        let completionHeader = $("<p></p>").html("<b>Completion Times</b>"); // Use paragraph
        productivityBottom.append(completionHeader);
        $.each(data.completionTimes, function (index, item) {
          let taskItem = $("<p></p>").html(
            // Use paragraph
            "<b>Task:</b> " +
              item.name +
              ", <b>Completed on:</b> " +
              item.completion_time
          );
          productivityBottom.append(taskItem);
        });
      }
    }
  }

  // Function to fetch and display the summary report
  function getSummaryReport() {
    $.ajax({
      url: "/task-productivity-tracker/php/api/productivity.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        displaySummaryReport(data);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching summary report:", status, error);
        $("#global-message").html(
          "<p class='text-danger'>Failed to load report.</p>"
        );
      },
    });
  }

  // Function to display the summary report in the HTML
  function displaySummaryReport(data) {
    let reportHTML = "";
    if (data) {
      reportHTML = "<p class='card-text'>All Tasks: " + data.all_tasks + "</p>";
      reportHTML +=
        "<p class='card-text'>Pending Tasks: " + data.pending_tasks + "</p>";
      reportHTML +=
        "<p class='card-text'>Completed Tasks: " +
        data.completed_tasks +
        "</p>";
    } else {
      reportHTML = "<p class='card-text'>No report data available.</p>";
    }
    $("#summaryReport").html(reportHTML);
  }

  let showPopup = false;
  // Call the function to get the report when the page loads
  getSummaryReport();

  // Event handler for the "Check Productivity" button
  $("#checkProductivity").click(function (e) {
    e.preventDefault();
    showPopup = true;
    updateProductivity(); // Call updateProductivity, which now calls both display functions

    //remove aria-hidden when shown
    $("#productivityPopup").on("shown.bs.modal", function () {
      $(this).removeAttr("aria-hidden");
    });

    //add aria hidden when hidden
    $("#productivityPopup").on("hidden.bs.modal", function () {
      $(this).attr("aria-hidden", "true");
    });
  });

  // Initial call on page load to display in bottom section
  updateProductivity();
});
