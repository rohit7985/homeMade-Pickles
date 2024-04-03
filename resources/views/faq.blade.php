@extends('layouts.main')
@section('title', 'FAQ and Help')
@section('main-content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">FAQ and Help</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">FAQ and Help</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- FAQ Section Start -->
    <div class="container py-5">
        <div class="accordion" id="faqAccordion">
            <!-- FAQ Item 1 -->
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question 1: What are your shipping options?
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                    <div class="card-body">
                        Answer : We offer standard and expedited shipping options. Standard shipping usually takes 3-5 business days, while expedited shipping takes 1-2 business days.
                    </div>
                </div>
            </div>

            <div class="card mt-20">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question 2: What is your return policy                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                    <div class="card-body">
                        Answer : We accept returns within 30 days of purchase. Please contact our customer service team for assistance with returns.
                    </div>
                </div>
            </div>
            <div class="card mt-20">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question 3: How can I track my order?
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                    <div class="card-body">
                        Answer : Once your order is shipped, you will receive a tracking number via email. You can use this tracking number to monitor the status of your delivery.
                    </div>
                </div>
            </div>
            <div class="card mt-20">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question 4: Do you offer international shipping?
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                    <div class="card-body">
                        Answer : Yes, we offer international shipping to select countries. Shipping rates and delivery times may vary depending on the destination.
                    </div>
                </div>
            </div>
            <div class="card mt-20">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question 5: What payment methods do you accept?
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                    <div class="card-body">
                        Answer : We accept various payment methods, including credit/debit cards, PayPal, and other secure online payment options. You can choose your preferred payment method at checkout.
                    </div>
                </div>
            </div>
            <div class="card mt-20">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question 1: What are your shipping options?
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                    <div class="card-body">
                        Answer: We offer standard and expedited shipping options. Standard shipping usually takes 3-5 business days, while expedited shipping takes 1-2 business days.
                    </div>
                </div>
            </div>
            <div class="card mt-20">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question 1: What are your shipping options?
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                    <div class="card-body">
                        Answer: We offer standard and expedited shipping options. Standard shipping usually takes 3-5 business days, while expedited shipping takes 1-2 business days.
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- FAQ Section End -->
@endsection
