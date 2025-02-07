<!-- Product Tabs -->
<div class="tabs-listing tab-details mt-0 mt-md-4">
           
    <!-- Tabs -->
      <ul class="product-tabs d-none d-md-block">
          <li class="active" rel="tab1"><a class="tablink">Product Details</a></li>
          {{-- <li rel="tab2"><a class="tablink">Product Reviews</a></li> --}}
          <li rel="tab3"><a class="tablink">Size Chart</a></li>
      </ul>
      <!-- End Tabs -->
    
    
      <!-- Tabs Container -->
      <div class="tab-container pb-0 mb-0">
          <!-- Tabs Content One -->
          <h3 class="acor-ttl active d-block d-md-none" rel="tab1">Product Details</h3>
          <div id="tab1" class="tab-content py-3 py-md-0" style="display:block;">
              <div class="product-description rte">
                  {!! $product->description !!}
              </div>
          </div>
          <!-- End Tabs Content One -->
    
          <!-- Tabs Content Two -->
          <h3 class="acor-ttl d-block d-md-none" rel="tab2">Product Reviews</h3>
          <div id="tab2" class="tab-content py-3 py-md-0">
              <div id="shopify-product-reviews">
                  <div class="spr-container">
                      <div class="spr-header clearfix">
                          <div class="spr-summary text-center d-flex justify-content-start justify-content-sm-between flex-column flex-sm-row">
                              <span class="product-review justify-content-center"><a class="reviewLink"><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star-half-alt"></i></a><span class="spr-summary-actions-togglereviews ms-2">Based on 6 reviews 456</span></span>
                              <span class="spr-summary-actions mt-3 mt-sm-0">
                                  <a href="#" class="spr-summary-actions-newreview write-review-btn btn"><i class="an-1x an an-pencil-alt me-1"></i> Write a review</a>
                              </span>
                          </div>
                      </div>
                      <div class="spr-content">
                          <div class="product-review-form spr-form clearfix" style="display:none;">
                              <form method="post" action="#" id="new-review-form" class="new-review-form">
                                  <h3 class="spr-form-title">Write a review</h3>
                                  <fieldset class="spr-form-contact">
                                      <div class="spr-form-contact-name">
                                          <label class="spr-form-label" for="review_author_10508262282">Name</label>
                                          <input class="spr-form-input spr-form-input-text" id="review_author_10508262282" type="text" name="review[author]" value="" placeholder="Enter your name">
                                      </div>
                                      <div class="spr-form-contact-email">
                                          <label class="spr-form-label" for="review_email_10508262282">Email</label>
                                          <input class="spr-form-input spr-form-input-email " id="review_email_10508262282" type="email" name="review[email]" value="" placeholder="john.smith@example.com">
                                      </div>
                                  </fieldset>
                                  <fieldset class="spr-form-review">
                                      <div class="spr-form-review-rating">
                                          <label class="spr-form-label">Rating</label>
                                          <div class="spr-form-input spr-starrating">
                                              <div class="product-review justify-content-start">
                                                  <a class="reviewLink" href="#"><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star-half-alt"></i></a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="spr-form-review-title">
                                          <label class="spr-form-label" for="review_title_10508262282">Review Title</label>
                                          <input class="spr-form-input spr-form-input-text" id="review_title_10508262282" type="text" name="review[title]" value="" placeholder="Give your review a title">
                                      </div>
                                      <div class="spr-form-review-body">
                                          <label class="spr-form-label" for="review_body_10508262282">Body of Review <span class="spr-form-review-body-charactersremaining">(1500)</span></label>
                                          <div class="spr-form-input">
                                              <textarea class="spr-form-input spr-form-input-textarea" id="review_body_10508262282" data-product-id="10508262282" name="review[body]" rows="5" placeholder="Write your comments here"></textarea>
                                          </div>
                                      </div>
                                  </fieldset>
                                  <fieldset class="spr-form-actions">
                                      <input type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" value="Submit Review">
                                  </fieldset>
                              </form>
                          </div>
                          <div class="spr-reviews">
                              <div class="spr-review">
                                  <div class="spr-review-header">
                                      <span class="product-review spr-starratings spr-review-header-starratings"><span class="reviewLink"><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i></span></span>
                                      <h3 class="spr-review-header-title">Lorem ipsum dolor sit amet</h3>
                                      <span class="spr-review-header-byline"><strong>dsacc</strong> on <strong>Apr 09, 2019</strong></span>
                                  </div>
                                  <div class="spr-review-content">
                                      <p class="spr-review-content-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                  </div>
                              </div>
                              <div class="spr-review">
                                  <div class="spr-review-header">
                                      <span class="product-review spr-starratings spr-review-header-starratings"><span class="reviewLink"><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star-half-alt"></i></span></span>
                                      <h3 class="spr-review-header-title">Lorem Ipsum is simply dummy text of the printing</h3>
                                      <span class="spr-review-header-byline"><strong>larrydude</strong> on <strong>Dec 30, 2018</strong></span>
                                  </div>
                                  <div class="spr-review-content">
                                      <p class="spr-review-content-body">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                      </p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- End Tabs Content Two -->
    
          <!-- Tabs Content Three -->
          <h3 class="acor-ttl d-block d-md-none" rel="tab3">Size Chart</h3>
          <div id="tab3" class="tab-content py-3 py-md-0">
              <div class="product-description rte">
                  <h4>WOMEN'S BODY SIZING CHART</h4>
                  <div class="table-responsive">
                      <table>
                          <tbody>
                              <tr>
                                  <th>Size</th>
                                  <th>XS</th>
                                  <th>S</th>
                                  <th>M</th>
                                  <th>L</th>
                                  <th>XL</th>
                              </tr>
                              <tr>
                                  <td>Chest</td>
                                  <td>31" - 33"</td>
                                  <td>33" - 35"</td>
                                  <td>35" - 37"</td>
                                  <td>37" - 39"</td>
                                  <td>39" - 42"</td>
                              </tr>
                              <tr>
                                  <td>Waist</td>
                                  <td>24" - 26"</td>
                                  <td>26" - 28"</td>
                                  <td>28" - 30"</td>
                                  <td>30" - 32"</td>
                                  <td>32" - 35"</td>
                              </tr>
                              <tr>
                                  <td>Hip</td>
                                  <td>34" - 36"</td>
                                  <td>36" - 38"</td>
                                  <td>38" - 40"</td>
                                  <td>40" - 42"</td>
                                  <td>42" - 44"</td>
                              </tr>
                              <tr>
                                  <td>Regular inseam</td>
                                  <td>30"</td>
                                  <td>30½"</td>
                                  <td>31"</td>
                                  <td>31½"</td>
                                  <td>32"</td>
                              </tr>
                              <tr>
                                  <td>Long (Tall) Inseam</td>
                                  <td>31½"</td>
                                  <td>32"</td>
                                  <td>32½"</td>
                                  <td>33"</td>
                                  <td>33½"</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <h4 class="mt-0 pt-1">MEN'S BODY SIZING CHART</h4>
                  <div class="table-responsive">
                      <table>
                          <tbody>
                              <tr>
                                  <th>Size</th>
                                  <th>XS</th>
                                  <th>S</th>
                                  <th>M</th>
                                  <th>L</th>
                                  <th>XL</th>
                                  <th>XXL</th>
                              </tr>
                              <tr>
                                  <td>Chest</td>
                                  <td>33" - 36"</td>
                                  <td>36" - 39"</td>
                                  <td>39" - 41"</td>
                                  <td>41" - 43"</td>
                                  <td>43" - 46"</td>
                                  <td>46" - 49"</td>
                              </tr>
                              <tr>
                                  <td>Waist</td>
                                  <td>27" - 30"</td>
                                  <td>30" - 33"</td>
                                  <td>33" - 35"</td>
                                  <td>36" - 38"</td>
                                  <td>38" - 42"</td>
                                  <td>42" - 45"</td>
                              </tr>
                              <tr>
                                  <td>Hip</td>
                                  <td>33" - 36"</td>
                                  <td>36" - 39"</td>
                                  <td>39" - 41"</td>
                                  <td>41" - 43"</td>
                                  <td>43" - 46"</td>
                                  <td>46" - 49"</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <div class="text-center mt-3">
                      <img src="{{asset('public/theme/assets/images/size.jpg')}}"  />
                  </div>
              </div>
          </div>
          <!-- End Tabs Content Three -->
          <!-- End Tabs Content Four -->
      </div>
      <!-- End Tabs Container -->
  </div>
  <!-- End Product Tabs -->