(function() {
	var StripeBilling = {
		init: function() {
			this.form = $('#billing-form');
			this.submitButton = this.form.find('button[type=submit]');
			this.submitButtonValue = this.submitButton.val();

			var stripeKey = 'pk_test_4Roa6Vi6NAnLM1Bz3LO0Ce71';
			Stripe.setPublishableKey(stripeKey);

			this.bindEvents();
		},

		bindEvents: function() {
			this.form.on('submit', $.proxy(this.sendToken, this));
		},

		sendToken: function(event) {
			this.submitButton.val('One Moment').prop('disabled', true);

			Stripe.createToken(this.form, $.proxy(this.stripeResponseHandler, this));
			event.preventDefault();
		},

		stripeResponseHandler: function(status, response) {

			this.submitButton.val(this.submitButtonValue);
			// console.log(status, response);
			if(response.error) {
				this.form.find('.payment-errors').text(response.error.message);
				return this.submitButton.prop('disabled', false).val(this.submitButtonValue);
			}

			$('<input>', {
				type: 'hidden',
				name: 'stripe-token',
				value: response.id
			}).appendTo(this.form);

			// this.form.find('.payment-errors').text('valid card');
			this.form[0].submit();
		}
	};

	StripeBilling.init();
})();