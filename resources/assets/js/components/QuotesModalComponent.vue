<template>
	<table class="quote-receives">
		<thead>
			<tr class="quote-header">
				<th style="width: 70px;"></th>
				<th style="width: 17%;">Business</th>
				<th style="width: 15%;">Quote</th>
				<th style="width: 15%;">Quote Expiry</th>
				<th style="width: 15%;">Status</th>
				<th style="width: 15%;"></th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(quote, index) in quotes.list">
				<td class="thumb">
					<img :src="quote.user.vendor_profile.profile_avatar || 'http://via.placeholder.com/61x61'" alt="" class="thumb">
				</td>
				<td>
					<div class="vendor">{{ quote.user.vendor_profile.business_name }}</div>
				</td>
				<td>
					<div class="amount">$ {{ quote.total }}</div>
				</td>
				<td>
					<div class="date">{{ quote.duration }}</div>
				</td>
				<td>
                    <div class="date" v-if="quote.status == 1">Awaiting Your Response</div>
                    <div class="date" v-if="quote.status == 2">Requested Changes</div>
                    <div class="date" v-if="quote.status == 3">Quote Accepted</div>
                    <div class="date" v-if="quote.status == 4">Quote Declined</div>
                    <div class="date" v-if="quote.status == 5">Quote Expired</div>
                    <div class="date" v-if="quote.status == 6">Quote Withdrawn</div>
				</td>
				<td>
					<a :href="'/dashboard/job-quotes/' + quote.id" class="btn wb-btn-outline-primary">View</a>
				</td>
			</tr>
			<tr v-show="quotes.list.length <= 0">
				<td colspan="6">
					<p class="text-center">Emtpy Job Quotes.</p>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
	export default {
		data() {
			return {
				quotes: window.wbQuotes,
			}
		}
	}
</script>
