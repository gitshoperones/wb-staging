<template>
	<table class="table" id="milestones-component">
		<thead>
			<tr style="font-weight: 400; color: #353554;">
				<th style="font-weight: 400; text-transform: capitalize;">Description</th>
				<th style="font-weight: 400; text-transform: capitalize;">Amount Due</th>
				<!-- <th style="font-weight: 400; text-transform: capitalize;"></th> -->
				<th style="font-weight: 400; text-transform: capitalize;">Due Date</th>
				<th style="font-weight: 400; text-transform: capitalize;"></th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(milestone, index) in milestones">
				<td style="font-weight: 300; text-transform: capitalize;">
					{{ milestone.desc }}
					<input type="hidden"
						class="notes wb-border-round-xs wb-border-input"
						:value="milestone.desc"
						name="milestones[descs][]">
				</td>
				<td class="cost" style="padding-left: 0;">
					<span style="position: relative; left: 15px;">$</span>
					<input style="width: 85px; padding: 0px 5px; text-indent: 15px;"
                        class="amount-due"
                        type="text"
                        v-model="milestone.amount"
						v-on:change="validateAmount(index)"></td>
				<!-- <td> -->
					<input class="percent-due"
                        type="hidden"
                        v-model="milestone.percent"
						name="milestones[percents][]">
					<!-- {{ roundOfpercent(milestone.amount) }}% -->
				<!-- </td> -->
				<td>
					<input type="text"
    					:id="index"
                        onkeydown="return false"
    					class="due-date"
    					v-model="milestone.due_date"
    					v-on:blur="syncDate(index)"
    					name="milestones[due_dates][]"
    					data-date-format="dd/mm/yyyy"
    					data-date-start-date="+1d">
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
	export default {
		data() {
			return {
				milestones: [
					{percent: 0, amount: 0, due_date: '', desc: 'deposit'},
					{percent: 0, amount: 0, due_date: '', desc: 'balance'},
				],
				total: window._wbQuote_
			}
		},
		methods: {
			roundOfpercent (amount) {
				if (amount && amount > 0 && isNaN(amount) === false && this.total.totalPayable !== 0) {
					return this.formatToDecimal(parseFloat((amount / this.total.totalPayable) * 100));
				}
				return 0;
			},
			compute(amount) {
				if (amount && amount > 0 && isNaN(amount) === false && this.total.totalPayable !== 0) {
					console.log((amount / this.total.totalPayable) * 100);
					return (amount / this.total.totalPayable) * 100;
				}
				return 0;
			},
			computeAmount(percent) {
				if (percent && percent > 0 && isNaN(percent) === false && this.total.totalPayable !== 0) {
					console.log('percent', (percent / 100) * this.total.totalPayable);
					return this.formatToDecimal(parseFloat((percent / 100) * this.total.totalPayable));
				}
				return 0;
			},
			syncDate(index) {
                if ($('#milestones-component #'+index).val()) {
                    this.milestones[index].due_date = $('#milestones-component #'+index).val();
                } else {
                    $('#milestones-component #'+index).val(this.milestones[index].due_date);
                }
			},
			formatToDecimal(num) {
				var val =  +(Math.round(num + "e+2")  + "e-2");
				return val > 0 ? val : '';
			},
			validateAmount(index) {
				let percentTotal = 0;

				if(this.total.totalPayable === 0) {
					return alert('Please insert your quote amount in Step 1.');
				}

				this.milestones[index].percent = this.compute(this.milestones[index].amount);
				
				for(let i in this.milestones) {
                    let percent = this.milestones[i].percent;
                    if (percent > 0) {
                        percentTotal = percentTotal + percent;
                    }
				}

				if ((index === 0 && this.milestones[1].percent > 0 && this.milestones[index].percent !== 0 && percentTotal != 100)
					|| (index === 1 && this.milestones[0] !== 0 && percentTotal != 100)
					|| this.milestones[index].percent > 100
				) {
					alert('Your deposit and balance must add up to $' + this.total.totalPayable);
				}
			},
			validatePercent(index) {
				let percentTotal = 0;

				for(let i in this.milestones) {
                    let percent = parseInt(this.milestones[i].percent);
                    if (percent > 0) {
                        percentTotal = parseInt(percentTotal) + percent;
                    }
				}

				if ((index === 1 && percentTotal != 100) || this.milestones[index].percent > 100) {
                    this.milestones[index].percent = 0;
					alert('Your deposit and balance must add up to 100%');
				}
			}
		},
		mounted() {
            window._wbQuote_.milestones = window._wbQuote_.milestones ? JSON.parse(window._wbQuote_.milestones) : null;

			if (Array.isArray(window._wbQuote_.milestones) && window._wbQuote_.milestones.length) {
				for (var i in window._wbQuote_.milestones) {
                    var milestones = window._wbQuote_.milestones[i];

                    if (milestones.desc === 'deposit') {
						this.milestones[0].amount = this.computeAmount(parseFloat(milestones.percent));
                        this.milestones[0].percent = milestones.percent;
                        this.milestones[0].due_date = milestones.due_date;
                    }
                    if (milestones.desc === 'balance') {
						this.milestones[1].amount = this.computeAmount(parseFloat(milestones.percent));
                        this.milestones[1].percent = milestones.percent;
                        this.milestones[1].due_date = milestones.due_date;
                    }
                }
			}

            setTimeout(function(){
                $('.due-date').datepicker();
            },2000);
		}
	}
</script>