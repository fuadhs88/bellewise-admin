

<template>

<div>



	<div class="card">
  <div class="card-content">
    <div class="content is-bold has-text-centered subtitle">

  <span class="fa"> Content will be gotten from customer app. </span>

    </div>
  </div>
</div>









	<div class="container" v-if="false"> <!-- Container tag open -->

		<nav class="level">

			<div class="level-item has-text-centered">
				<div class="field has-addons">
					<div class="control">
						<input class="input" type="text" placeholder="Search User">
					</div>
					<div class="control">
						<a class="button purple-color">
							Search
						</a>
					</div>
				</div>
			</div>

		</nav>


		<div class="notification is-light is-bold pointer" @click="display=!display">
			<span> Send NOtification and Email To Users </span> <span class="fas fa-angle-down purple-color is-pulled-right"></span>
		</div>


		<div class="box" v-if="display"> <!-- Box container tag open -->

			<div class="field">
				<div class="control">
					<label class="radio">
						<input type="radio" value="notification" v-model="picked">
						Send Notification / SMS
					</label>
					<label class="radio">
						<input type="radio" value="email" v-model="picked">
						Send Email
					</label>
				</div>
			</div>


			<!-- Notification section -->
			<div class="" v-if=" 'notification' == picked"> 

				<div class="field">
					<label class="label"> Notification </label>
					<div class="control">
						<textarea class="textarea" placeholder=" Enter Notification Content"></textarea>
					</div>
				</div>


				<div class="field is-grouped is-grouped-right">
					<div class="control">
						<button class="button purple-color is-bold">Send</button>
					</div>
				</div>

			</div>
			<!-- Notification section -->


			<!-- Email section -->
			<div class="" v-if=" 'email' == picked ">

				<div class="field">
					<label class="label"> Subject </label>
					<div class="control">
						<input class="input" type="text" placeholder="Text input">
					</div>
				</div>


				<div class="field">
					<label class="label">Message</label>
					<div class="control">
						<tinymce-editor api-key="API_KEY" :init="{plugins: 'wordcount'}" />
					</div>
				</div>

				<div class="field is-grouped is-grouped-right">
					<div class="control">
						<button class="button purple-color is-bold">Send</button>
					</div>
				</div>


			</div>
			<!-- Email section -->

		</div> <!-- Box container tag close -->


		<div class="card"> <!-- Card tag open -->

			<div class="card-content table-container"> <!-- Card content tag open -->

				<table class="table is-bordered is-striped is-hoverable"> <!-- Table tag open -->

					<thead>
						<tr>
							<th> </th>
							<th> <span class="purple-color"> ID </span> </th>
							<th> <span class="purple-color"> Name </span> </th>
							<th class="has-text-centered"> <span class="purple-color"> Email </span> </th>
							<th class="has-text-centered"> <span class="purple-color"> Phone </span> </th>
							<th> <span class="purple-color"> Joined On </span> </th>
							<th> <span class="purple-color">  Total Orders </span>  </th>
						</tr>
					</thead>

					<tbody>

						<tr>
							<td class="has-text-centered"> <input type="checkbox"> </td>
							<th> <span class="purple-color"> 1 </span> </th>
							<td> Joseph Purple </td>
							<td> Purple@gmail.com </td>
							<td> 080XXXXXXX </td>
							<td> May 11, 2020 </td>
							<td class="has-text-centered"> 23 </td>
						</tr>


						<tr>
							<td class="has-text-centered"> <input type="checkbox"> </td>
							<th> <span class="purple-color"> 2 </span> </th>
							<td> Joseph Purple </td>
							<td> Purple@gmail.com </td>
							<td> 080XXXXXXX </td>
							<td> May 11, 2020 </td>
							<td class="has-text-centered"> 23 </td>
						</tr>


						<tr>
							<td class="has-text-centered"> <input type="checkbox"> </td>
							<th> <span class="purple-color"> 3 </span> </th>
							<td> Joseph Purple </td>
							<td> Purple@gmail.com </td>
							<td> 080XXXXXXX </td>
							<td> May 11, 2020 </td>
							<td class="has-text-centered"> 23 </td>
						</tr>


						<tr>
							<td class="has-text-centered"> <input type="checkbox"> </td>
							<th> <span class="purple-color"> 4 </span> </th>
							<td> Joseph Purple </td>
							<td> Purple@gmail.com </td>
							<td> 080XXXXXXX </td>
							<td> May 11, 2020 </td>
							<td class="has-text-centered"> 23 </td>
						</tr>


						<tr>
							<td class="has-text-centered"> <input type="checkbox"> </td>
							<th> <span class="purple-color"> 5 </span> </th>
							<td> Joseph Purple </td>
							<td> Purple@gmail.com </td>
							<td> 080XXXXXXX </td>
							<td> May 11, 2020 </td>
							<td class="has-text-centered"> 23 </td>
						</tr>

					</tbody>

				</table> <!-- Table tag close -->

<!-- Pagination section -->
<div class="buttons has-addons is-centered">
  <a class="button">
    <span class="icon is-small">
      <i class="fas fa-arrow-left green"></i>
    </span>
    <span> Previous </span>
  </a>


  <a class="button">

    5 0f 6
  </a>


  <a class="button">
    <span class="icon is-small">
      <i class="fas fa-arrow-right green"></i>
    </span>
    <span> Next </span>
  </a>

</div>

			</div> <!-- Card content tag open -->


		</div> <!-- Card tag close -->







	</div> <!-- Container tag close -->








</div>


</template>

<script>

import BulmaCalendar from "../../../Mixins/bulmaCalendar.js";
import Editor from "../../../Mixins/tinymceEditor.js";

export default {

	mixins: [
	BulmaCalendar,
	Editor,
	],

	data: () => ({
		display: false,
		picked: "notification",
	}),

}

</script>