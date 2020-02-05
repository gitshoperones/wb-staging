<template>
	<table id="jobSpecTbl" class="table table-hover"  style="font-weight: 300 !important">
		<thead>
			<tr>
				<th style="width: 70%">Description</th>
				<th style="width: 25%">Amount (excl GST)</th>
				<th style="width: 5%"></th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(spec, index) in quoteSpecs">
				<td class="title">
					<input type="text"
						v-model="spec.title"
						name="specs[titles][]"
						class="wb-border-round-xs wb-border-input" style="width: 100%;" />
				</td>
				<td class="dollarwrapper">
					<span class="dollarsign">$</span>
					<input type="number"
						v-model="spec.cost"
						v-on:keyup="compute()"
						v-on:change="compute()"
						name="specs[costs][]"
						step="any"
						class="costs wb-border-round-xs wb-border-input" style="width: calc(100% - 13px);"/>
				</td>
				<td>
					<a href="#" v-if="index !== 0" @click.prevent="removeElement(index)">
						<i class="fa fa-remove text-danger"></i>
					</a>
				</td>
			</tr>
			<tr>
				<td>
					<button type="button" @click.prevent="addSpecs()" class="btn wb-btn-orange" style="margin-bottom: 10px;
						padding: 2px 8px;
						font-size: 12px;
						margin: -2px 0 3px;">
						<i class="fa fa-plus"></i> New Line</button>
				</td>
				<td></td>
			</tr>
			<tr v-if="applyGst == 1">
				<td>
					10% GST
				</td>
				<td colspan="3">${{ taxAmount.toFixed(2) }}</td>
			</tr>
			<tr>
				<td>
					<span class="tooltip"></span>
					<strong>Total Payable</strong>
					
				</td>
				<td colspan="3">
					${{ totalPayable.toFixed(2) }}
				</td>
			</tr>
			<tr>
				<td>
					You will receive
					<span class="right-icon tooltip-icon tool1" style="position: relative;">
						<i class="fa fa-question-circle"></i>
					</span>
				</td>
				<td colspan="3">
					${{ amountReceivable.toFixed(2) }}
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
	export default {
		computed: {
			totalPayable() {
				return this.taxAmount + this.totalAmount;
			},
            amountReceivable() {
                return this.totalPayable - this.feesAmount;
            },
			taxAmount() {
				return (this.tax / 100) * this.totalAmount;
			},
			feesAmount() {
				return (this.fees / 100) * this.totalPayable;
			},
		},
		data() {
			return {
				quoteSpecs: [ {title: '', cost: 0, note: ''}],
				totalAmount: 0.00,
				tax: 10.00,
				fees: 10,
				applyGst: 1,
			}
		},
		methods: {
			addSpecs: function() {
				this.quoteSpecs.push({title: '', cost: 0, note: ''});
			},
			compute: function() {
				if (this.applyGst) {
					this.tax = 10.00;
				} else {
					this.tax = 0;
				}
				this.totalAmount = 0.00;
				for(let i in this.quoteSpecs) {
					if (this.quoteSpecs[i].cost && this.quoteSpecs[i].cost > 0 && isNaN(this.quoteSpecs[i].cost) === false) {
						this.totalAmount += parseFloat(this.formatToDecimal(this.quoteSpecs[i].cost));
					}
				}
				window._wbQuote_.totalPayable = this.totalPayable;
			},
			removeElement: function(index) {
				this.quoteSpecs.splice(index, 1);
				this.compute();
			},
			formatToDecimal: function(num) {
				return +(Math.round(num + "e+2")  + "e-2");
			},
			fixDecimal: function(num) {
				return num.toFixed(2);
			}
		},
		mounted: function() {
            window._wbQuote_.quoteSpecs = window._wbQuote_.quoteSpecs ? JSON.parse(window._wbQuote_.quoteSpecs) : null;

            if (Array.isArray(window._wbQuote_.quoteSpecs) && window._wbQuote_.quoteSpecs.length) {
				this.quoteSpecs = window._wbQuote_.quoteSpecs;
			}

			if (window._wbQuote_ && window._wbQuote_.applyGst) {
                this.applyGst = parseInt(window._wbQuote_.applyGst);
            }

            if (window._wbQuote_ && window._wbQuote_.totalWedbookerFee) {
				this.fees = window._wbQuote_.totalWedbookerFee;
			}

			this.compute();
		}
	}
</script>
