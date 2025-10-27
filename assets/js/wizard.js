const jQuery = window.jQuery
const nonyLabsWizard = window.nonyLabsWizard

jQuery(document).ready(($) => {
  let currentStep = 1
  const totalSteps = 4

  function updateProgress() {
    const progress = ((currentStep - 1) / (totalSteps - 1)) * 100
    $(".progress-fill").css("width", progress + "%")

    $(".progress-steps .step").each(function () {
      const stepNum = $(this).data("step")
      if (stepNum < currentStep) {
        $(this).addClass("completed").removeClass("active")
      } else if (stepNum === currentStep) {
        $(this).addClass("active").removeClass("completed")
      } else {
        $(this).removeClass("active completed")
      }
    })
  }

  function showStep(step) {
    $(".wizard-step").removeClass("active")
    $('.wizard-step[data-step="' + step + '"]').addClass("active")

    if (step === 1) {
      $(".wizard-prev").hide()
    } else {
      $(".wizard-prev").show()
    }

    if (step === totalSteps) {
      $(".wizard-next").hide()
      $(".wizard-finish").show()
    } else {
      $(".wizard-next").show()
      $(".wizard-finish").hide()
    }

    updateProgress()
  }

  function saveCurrentStep(callback) {
    let data = {}

    switch (currentStep) {
      case 2:
        data = {
          nav_logo: $("#wizard_nav_logo").val(),
          site_title: $("#wizard_site_title").val(),
        }
        break
      case 3:
        const badges = []
        $(".wizard-badge-text").each(function () {
          const text = $(this).val()
          if (text) badges.push(text)
        })
        data = { badges: badges }
        break
      case 4:
        const social = []
        $(".wizard-social-item").each(function () {
          const platform = $(this).find(".wizard-social-platform").val()
          const url = $(this).find(".wizard-social-url").val()
          const username = $(this).find(".wizard-social-username").val()
          if (url) {
            social.push({ platform, url, username })
          }
        })
        data = { social: social }
        break
    }

    $.ajax({
      url: nonyLabsWizard.ajaxurl,
      type: "POST",
      data: {
        action: "nonylabs_wizard_save_step",
        nonce: nonyLabsWizard.nonce,
        step: currentStep,
        data: data,
      },
      success: (response) => {
        if (callback) callback()
      },
    })
  }

  $(".wizard-next").on("click", () => {
    saveCurrentStep(() => {
      if (currentStep < totalSteps) {
        currentStep++
        showStep(currentStep)
      }
    })
  })

  $(".wizard-prev").on("click", () => {
    if (currentStep > 1) {
      currentStep--
      showStep(currentStep)
    }
  })

  $(".wizard-finish").on("click", () => {
    saveCurrentStep(() => {
      window.location.href = '<?php echo admin_url( "admin.php?page=nonylabs-settings" ); ?>'
    })
  })

  $(".wizard-skip").on("click", () => {
    if (confirm("Are you sure you want to skip the setup wizard?")) {
      $.ajax({
        url: nonyLabsWizard.ajaxurl,
        type: "POST",
        data: {
          action: "nonylabs_wizard_skip",
          nonce: nonyLabsWizard.nonce,
        },
        success: (response) => {
          if (response.success) {
            window.location.href = response.data.redirect
          }
        },
      })
    }
  })

  // Add badge
  $("#wizard-add-badge").on("click", () => {
    const html =
      '<div class="wizard-badge-item">' +
      '<input type="text" class="regular-text wizard-badge-text" placeholder="Badge text" />' +
      '<button type="button" class="button wizard-remove-badge">Remove</button>' +
      "</div>"
    $("#wizard-badges-container").append(html)
  })

  // Remove badge
  $(document).on("click", ".wizard-remove-badge", function () {
    $(this).closest(".wizard-badge-item").remove()
  })

  // Add social link
  $("#wizard-add-social").on("click", () => {
    const html =
      '<div class="wizard-social-item">' +
      '<input type="text" class="regular-text wizard-social-platform" placeholder="Platform name" />' +
      '<input type="url" class="regular-text wizard-social-url" placeholder="Profile URL" />' +
      '<input type="text" class="regular-text wizard-social-username" placeholder="Username" />' +
      '<button type="button" class="button wizard-remove-social">Remove</button>' +
      "</div>"
    $("#wizard-social-container").append(html)
  })

  // Remove social link
  $(document).on("click", ".wizard-remove-social", function () {
    $(this).closest(".wizard-social-item").remove()
  })

  // Initialize
  showStep(currentStep)
})
