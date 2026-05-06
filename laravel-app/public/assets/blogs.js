(function () {
  function formToQuery($form) {
    const data = $form.serializeArray();
    const params = new URLSearchParams();
    data.forEach(({ name, value }) => {
      if (value != null && String(value).trim() !== "") params.set(name, value);
    });
    return params.toString();
  }

  function setMeta(count) {
    const $meta = $("#results-meta");
    if (count == null) {
      $meta.text("");
      return;
    }
    $meta.text(count === 1 ? "1 blog" : `${count} blogs`);
  }

  function loadResults(url) {
    $("#blogs-list").addClass("is-loading");
    return $.ajax({
      url,
      method: "GET",
      headers: { "X-Requested-With": "XMLHttpRequest" },
      dataType: "json",
    })
      .done((res) => {
        $("#blogs-list").html(res.html);
        setMeta(res.count);
      })
      .fail(() => {
        $("#blogs-list").html(
          '<div class="card empty"><h2 class="h2">Something went wrong</h2><p class="muted">Please try again.</p></div>'
        );
      })
      .always(() => {
        $("#blogs-list").removeClass("is-loading");
      });
  }

  $(document).on("submit", "#blog-filter", function (e) {
    e.preventDefault();
    const qs = formToQuery($(this));
    const url = qs ? `/blogs?${qs}` : "/blogs";
    history.replaceState(null, "", url);
    loadResults(url);
  });

  $(document).on("click", "#reset-filter", function () {
    $("#blog-filter")[0].reset();
    const url = "/blogs";
    history.replaceState(null, "", url);
    loadResults(url);
  });

  // AJAX pagination
  $(document).on("click", "#blogs-list .pagination a", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    if (!url) return;
    history.replaceState(null, "", url);
    loadResults(url);
  });
})();

