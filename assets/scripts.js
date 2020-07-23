(function ($, undefined) {
	$(function() {
		"use strict";

		$(document).on('change', 'select[name="hh_x_frame_options_value"]', function () {
			var $el = $('input[name="hh_x_frame_options_domain"]'),
				readOnly = $(this).find('option:selected').val() != 'allow-from';
			if ($el.length) {
				$el.prop('readOnly', readOnly).toggle(!readOnly);
			}
		}).on('change', 'select[name="hh_x_xxs_protection_value"]', function (e) {
			var $el = $('input[name="hh_x_xxs_protection_uri"]'),
				readOnly = $(this).find('option:selected').val() != '1; report=';
			if ($el.length) {
				$el.prop('readOnly', readOnly).toggle(!readOnly);
			}
		}).on('change', 'select[name="hh_x_powered_by_option"]', function () {
			var $el = $('input[name="hh_x_powered_by_value"]'),
				readOnly = $(this).find('option:selected').val() != 'set';
			if ($el.length) {
				$el.prop('readOnly', readOnly).toggle(!readOnly);
			}
        }).on("change", "input[name^='hh_vary_value[']", function () {

            if (this.name === "hh_vary_value[*]") {
                if (this.checked) {
                    $("input[name^='hh_vary_value[']").not(this).prop("checked", false);
                }
            } else {
                if (this.checked) {
                    $("input[name='hh_vary_value[*]']").prop("checked", false);
                }
            }

        }).on("change", "input[name^='hh_access_control_allow_methods_value[']", function () {

        	if (this.name === "hh_access_control_allow_methods_value[*]") {
                if (this.checked) {
                    $("input[name^='hh_access_control_allow_methods_value[']").not(this).prop("checked", false);
                }
            } else {
        		if (this.checked) {
        			$("input[name='hh_access_control_allow_methods_value[*]']").prop("checked", false);
				}
			}

		}).on('change', 'select[name="hh_access_control_allow_origin_value"]', function () {
			var $el = $('input[name="hh_access_control_allow_origin_url"]'),
				readOnly = $(this).find('option:selected').val() != 'origin';
			if ($el.length) {
				$el.prop('readOnly', readOnly);//.toggle(!readOnly);
			}
			if (readOnly) {
				$(".hh-acao").addClass("hh-hidden");
			} else {
				$(".hh-acao").removeClass("hh-hidden");
			}
		}).on('change', 'select[name="hh_timing_allow_origin_value"]', function () {
			var $el = $('input[name="hh_timing_allow_origin_url"]'),
				readOnly = $(this).find('option:selected').val() != 'origin';
			if ($el.length) {
				$el.prop('readOnly', readOnly).toggle(!readOnly);
			}
		}).on('change', '.http-header', function () {
			var $this = $(this),
				$el = $this.closest('table').find('.http-header-value');
			
			if (!$el.length) {
				return;
			}
			
			if (Number($this.val()) === 1) {
				$el.prop('readOnly', false).removeAttr('readonly').removeClass('readonly');
			} else {
				$el.prop('readOnly', true).addClass('readonly');
			}
		}).on('change', 'input[name="hh_x_frame_options"]', function () {
			$('select[name="hh_x_frame_options_value"]').trigger('change');
		}).on('change', 'input[name="hh_x_powered_by"]', function () {
			$('select[name="hh_x_powered_by_option"]').trigger('change');
		}).on('change', 'input[name="hh_access_control_allow_origin"]', function () {
			$('select[name="hh_access_control_allow_origin_value"]').trigger('change');
		}).on('change', 'input[name="hh_timing_allow_origin"]', function () {
			$('select[name="hh_timing_allow_origin_value"]').trigger('change');
		}).on('submit', '#frmIspect', function (e) {
			e.preventDefault();
			var $this = $(this),
				$box = $('#hh-result').empty();
			$.post($this.attr('action'), $this.serialize()).done(function (data) {
				$box.html(data);
			});
			return false;
		}).on('change', '#authentication', function () {
			var $a = $('#box-authentication');
			if (this.checked) {
				$a.show();
			} else {
				$a.hide();
			}
		}).on('click', '#hh-btn-add-header', function () {
			$(this).closest('tr').before('<tr> \
					<td><input type="text" name="hh_custom_headers_value[name][]" class="http-header-value" placeholder="X-Custom-Name"></td> \
					<td><input type="text" name="hh_custom_headers_value[value][]" class="http-header-value" placeholder="' + hh.lbl_value + '"></td> \
					<td><button type="button" class="button button-small hh-btn-delete-header" title="' + hh.lbl_delete + '">x</button></td> \
				</tr>');
		}).on('click', '.hh-btn-add-endpoint', function () {
			
			var $tr = $(this).closest("tr");
			
			$tr.children("td").each(function() {
				if ($(this).attr("rowspan") !== undefined) {
					this.rowSpan = this.rowSpan + 1;
				}
			});
			
			var name,
				$clone = $tr.clone().removeClass("hh-tr-first hh-tr-group-start"),
				$this = $(this),
				index = Math.ceil(Math.random() * 9999);
			
			if ($tr.hasClass("hh-tr-group-end")) {
				name = $tr.find("input[name$='[url]']").attr("name");
			} else {
				name = $tr.nextAll(".hh-tr-group-end:eq(0)").find("input[name$='[url]']").attr("name");
			}
			
			var m = name.match(/\[(\d+)\]\[url\]$/),
				index = Number(m[1]) + 1;
			
			$clone.find("td").each(function() {
				if ($(this).attr("rowspan") !== undefined) {
					$(this).remove();
				}
			});
			
			$clone.find('input[type="text"]').val("");
			$clone.find('input[type="number"]').val("");
			$clone.find("td:last").html('<button type="button" class="button hh-btn-delete-endpoint" title="' + hh.lbl_delete + '">' + hh.lbl_remove_endpoint + '</button>');
			$clone.find(":input").each(function () {
				this.name = this.name.replace('[endpoints][0]', '[endpoints][' + index + ']');
			});
			
			$clone.addClass("hh-tr-group-end");
			if ($tr.hasClass("hh-tr-group-end")) {
				$tr.removeClass("hh-tr-group-end");
				$tr.after($clone);
			} else {
				$tr.nextAll(".hh-tr-group-end:eq(0)").removeClass("hh-tr-group-end").after($clone);
			}
			
		}).on('click', '#hh-btn-add-endpoint-group', function () {
			var $this = $(this),
				index = Math.ceil(Math.random() * 9999),
				$table = $this.closest("table"),
				$clone = $table.find("tr.hh-tr-first").eq(0).clone(),
				name = $table.find("tr:nth-last-child(2)").find(":input:first").attr("name"),
				m = name.match(/^hh_report_to_value\[(\d+)\]/),
				index = Number(m[1]) + 1;
			
			$clone.find("td").each(function() {
				if ($(this).attr("rowspan") !== undefined) {
					this.rowSpan = 1;
				}
			});
			
			$clone.find('input[type="text"]').val("");
			$clone.find('input[type="number"]').val("");
			$clone.find('input[type="checkbox"]').prop("checked", false);
			$clone.find("option:first").prop("selected", true);
			$clone.find("td:last").html('<button type="button" class="button hh-btn-delete-endpoint-group" title="' + hh.lbl_delete + '">' + hh.lbl_remove_group + '</button>');
			$clone.find(":input").each(function () {
				this.name = this.name.replace('[0]', '[' + index + ']');
			});
			$clone.addClass("hh-tr-group-end").removeClass("hh-tr-first");
			
			$this.closest('tr').before($clone);
		}).on('click', '.hh-btn-delete-header, .hh-btn-delete-origin, .hh-btn-delete-user, .hh-btn-delete-ac', function () {
			
			$(this).closest('tr').remove();
			
		}).on('click', '.hh-btn-delete-endpoint', function() {
			
			var $group,
				$tr = $(this).closest("tr");
			
			if ($tr.prev("tr").hasClass("hh-tr-group-start")) {
				$group = $tr.prev("tr");
			} else {
				$group = $tr.prevUntil("tr.hh-tr-group-start").prev("tr");
			}
			
			$group.children("td").each(function() {
				if (this.rowSpan > 1) {
					this.rowSpan = this.rowSpan - 1;
				}
			});

			if ($tr.hasClass("hh-tr-group-end")) {
				$tr.prev("tr").addClass("hh-tr-group-end");
			}
			
			$tr.remove();
			
		}).on('click', '.hh-btn-delete-endpoint-group', function () {
			var rows = $(this).closest("td").attr("rowspan");
			if (rows === undefined || rows < 2) {
				$(this).closest('tr').remove();
			} else {
				$(this).closest('tr').nextAll("tr").addBack().slice(0, rows).remove();
			}
        }).on("click", ".hh-btn-add-ac", function () {
        	var $this = $(this);
            $this.closest('tr').before('<tr> \
					<td><input type="text" name="' + $this.data("name") + '" class="http-header-value" size="35" /></td> \
					<td><button type="button" class="button button-small hh-btn-delete-ac" title="' + hh.lbl_delete + '">x</button></td> \
				</tr>');
		}).on("click", ".hh-btn-add-origin", function () {
			$(this).closest('tr').before('<tr class="hh-acao"> \
					<td>&nbsp;</td> \
					<td><input type="text" name="hh_access_control_allow_origin_url[]" class="http-header-value" placeholder="http://domain.com" size="35" /></td> \
					<td><button type="button" class="button button-small hh-btn-delete-origin" title="' + hh.lbl_delete + '">x</button></td> \
				</tr>');
		}).on("click", ".hh-btn-add-user", function () {
			$(this).closest('tr').before('<tr> \
					<td>&nbsp;</td> \
					<td><input type="text" name="hh_www_authenticate_user[]" class="http-header-value" /></td> \
					<td><input type="text" name="hh_www_authenticate_pswd[]" class="http-header-value" /></td> \
					<td><button type="button" class="button button-small hh-btn-delete-user" title="' + hh.lbl_delete + '">x</button></td> \
				</tr>');
		}).on("click", ".hh-btn-import-choose", function () {
			$("#hh-import-file").trigger("click");
		}).on("change", "#hh-import-file", function () {
			$("#hh-import-name").html(this.files[0].name);
		}).on("change", 'select[name^="hh_feature_policy_value"]', function () {
			var $this = $(this),
				value = $this.find("option:selected").val(),
				$input = $this.siblings('input[name^="hh_feature_policy_origin"]');
			if (value === "'self'" || value === "origin(s)") {
				$input.show();
			} else {
				$input.hide();
			}
		}).on("change", 'input[name^="hh_content_security_policy_value"]', function () {
			
			var $this = $(this);
			
			if (this.checked) {
				if (/\[\*\]$/.test(this.name)) {
					$this.closest("td").find('input[type="checkbox"]').not(this).prop("checked", false);
					$this.closest("p").siblings("p").hide();
				} else {
					$this.closest("td").find('input[type="checkbox"][name$="[*]"]').prop("checked", false);
				}
			} else {
				if (/\[\*\]$/.test(this.name)) {
					$this.closest("p").siblings("p").show();
				}
			}
		}).on("change", 'input[type="checkbox"][name="hh_cookie_security_value[SameSite]"]', function () {
			if (this.checked) {
				$(".hh-csv-value")
					.removeClass("hh-hidden")
					.find('input[type="radio"]')
					.prop("disabled", false)
					.filter(":first")
					.prop("checked", true);
			} else {
                $(".hh-csv-value")
					.addClass("hh-hidden")
					.find('input[type="radio"]')
					.prop("disabled", true);
			}
		});
		
		$('.hh-tabs').on('click', 'ul a', function (e) {
			e.preventDefault();
			
			var $this = $(this);
			$($this.attr('href'))
				.removeClass('hh-hidden').addClass('hh-tab-active').attr('aria-hidden', 'false').attr('aria-expanded', 'true')
				.siblings('div').addClass('hh-hidden').removeClass('hh-tab-active').attr('aria-hidden', 'true').attr('aria-expanded', 'false');
			$this.closest('li')
				.addClass('hh-active').attr('aria-selected', 'true').attr('tabindex', 0)
				.siblings('li').removeClass('hh-active').attr('aria-selected', 'false').attr('tabindex', -1);
		}).each(function () {
			var $this = $(this),
				$ul = $this.children('ul').attr('role', 'tablist'),
				$li = $ul.children('li').attr('role', 'tab')
					.not(':first').attr('aria-selected', 'false').attr('tabindex', -1)
					.end().eq(0).attr('aria-selected', 'true').attr('tabindex', 0)
					.end(),
				$a = $li.find('a').attr('role', 'presentation').attr('tabindex', -1),
				$div = $this.children('div').attr('role', 'tabpanel')
					.not(':first').attr('aria-hidden', 'true').attr('aria-expanded', 'false')
					.end().eq(0).attr('aria-hidden', 'false').attr('aria-expanded', 'true')
					.end();
			
			$li.each(function (i) {
				var $this = $(this),
					id = 'hh-tabs-' + Math.ceil(Math.random() * 999999) + '-' + i,
					$a = $this.attr('aria-labelledby', id).find('a').attr('id', id),
					href = $a.attr('href');
				$this.attr('aria-controls', href.substring(1)).attr('aria-labelledby', id);
				$(href).attr('aria-labelledby', id);
			});
			
		});
	});
})(jQuery);