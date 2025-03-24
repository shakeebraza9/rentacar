@extends('admin.layout')
@section('css')
<style>
    .invalid-feedback{
      display: block;
   }
   .dateandtime{
    gap:
20px;
  padding:
10px;
  border:
1px solid rgb(221, 221, 221);
  border-radius:
8px;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 10px;
  background-color: rgb(249, 249, 249);
  margin-top: 20px;
   }


   .switch {
  font-size: 17px;
  position: relative;
  display: inline-block;
  width: 3.5em;
  height: 2em;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background: #9fccfa;
  border-radius: 50px;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.slider:before {
  position: absolute;
  content: "";
  display: flex;
  align-items: center;
  justify-content: center;
  height: 2em;
  width: 2em;
  inset: 0;
  background-color: white;
  border-radius: 50px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.4);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.switch input:checked + .slider {
  background: #0974f1;
}

.switch input:focus + .slider {
  box-shadow: 0 0 1px #0974f1;
}

.switch input:checked + .slider:before {
  transform: translateX(1.6em);
}

</style>

@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ADD YOUR SEASON
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Season</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header" style="background-color: #6b0909;">
                <h4 class="mb-0 text-white">Add Season</h4>
            </header>
            <div class="card-body">
                <form id="seasonForm" method="POST" action="{{ route('admin.peakseason.store') }}">
                    @csrf



                    <!-- Container for dynamically added seasons -->
                    <div id="">
                        @foreach ($seasons as $season)
                        <div class="season-container" style="background-color: #f1f1f1; padding: 20px; margin-bottom: 20px; border-radius: 8px;">
                            <h5>{{ $season->title }}</h5>
                            <p>Start Date: {{ $season->start_date }} | End Date: {{ $season->end_date }}</p>
                            <h6>Car Types and Prices:</h6>
                            <div class="car-types-section">
                                @foreach (json_decode($season->value) as $priceData)
                                    <div class="d-flex align-items-center mb-4">
                                        <div style="flex: 1;">
                                            <label for="car_type_{{ $priceData->car_type_title }}" style="font-weight: bold; color: #333;">
                                                {{ $priceData->car_type_title }}
                                            </label>
                                            <input type="text" class="form-control" value="{{ $priceData->price }}" readonly style="background-color: #f4f4f4; border: 1px solid #ccc; color: #555;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>




                            <div class="btn-group" style="display: flex; align-items: center; justify-content: space-between;">

                                <a href="{{ route('admin.peakseason.edit', $season->id) }}" class="btn btn-info btn-sm" style="margin-right: 10px;">Edit</a>



                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm deleteSeasonBtn2" data-id="{{ $season->id }}" style="margin-right: 10px;">
                                    <i class="fa fa-trash"></i> Delete
                                </button>

                                <!-- Enable/Disable Switch -->
                                <div class="custom-control custom-switch ml-3">
                                    <label class="switch">
                                        <input type="checkbox" class="toggleSeasonStatus" data-id="{{ $season->id }}" {{ $season->enable ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="status-label">{{ $season->enable ? 'Enabled' : 'Disabled' }}</span>
                                </div>
                                </div>
                            </div>

                        </div>
                    @endforeach


                    </div>
                    <div id="seasons_container">
                    </div>

                    <div class="form-group text-center" style="margin-top: 20px;">
                        <button type="button" id="addNewSeason" class="btn btn-primary" style="margin-right: 10px;">Add New Season</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('js')

<script>

    document.getElementById('addNewSeason').addEventListener('click', function() {
        // Create a new season container with a random background color
        const newSeasonContainer = document.createElement('div');
        newSeasonContainer.classList.add('season-container');

        // Assign a random background color from a set of colors
        const colors = ['#6b0909', '#4700af', '#009fff', '#ff8300', '#9C27B0', '#FFC107'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        newSeasonContainer.style.backgroundColor = randomColor;
        newSeasonContainer.style.padding = '20px';
        newSeasonContainer.style.marginBottom = '20px';
        newSeasonContainer.style.borderRadius = '8px';

        // Fetch car types via AJAX
        fetch('{{ route('admin.fetach.cartpe') }}')
            .then(response => response.json())
            .then(data => {
                // Season Header
                newSeasonContainer.innerHTML = `
                    <div class="season-header" style="margin-bottom: 20px; color: white; padding: 10px; border-radius: 8px;">
                        <h5>New Season</h5>
                        <label for="season_name">Season Name</label>
                        <input type="text" name="season_name[]" class="form-control" placeholder="Enter Season Name" required>
                      <div class="d-flex align-items-center mb-4 dateandtime">
                        <div class="col-md-6" style="flex: 1;">
                            <label for="season_start_date">Start Date</label>
                            <input type="date" name="season_start_date[]" class="form-control" required>
                        </div>
                        <div class="col-md-6" style="flex: 1;">
                            <label for="season_end_date">End Date</label>
                            <input type="date" name="season_end_date[]" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="car-types-section" style="margin-top: 20px;">
                    <h6>Car Types and Prices</h6>
                </div>
                <button type="button" class="btn btn-danger deleteSeasonBtn" style="margin-top: 10px;">Delete This Season</button>
            `;

                const carTypesSection = newSeasonContainer.querySelector('.car-types-section');

                // Loop through the car types and add them to the form
                data.cartypes.forEach(cartype => {
                    const newField = document.createElement('div');
                    newField.classList.add('d-flex', 'align-items-center', 'mb-4');
                    newField.style = 'gap: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;';
                    newField.setAttribute('data-cartype-slug', cartype.slug); // Save the slug instead of ID

                    newField.innerHTML = `
                        <div style="flex: 1;">
                            <label for="car_type_${cartype.slug}" style="font-weight: bold; color: #333;">${cartype.title}</label>
                            <input type="text" class="form-control" value="${cartype.title}" readonly style="background-color: #f4f4f4; border: 1px solid #ccc; color: #555;">
                        </div>
                        <div style="flex: 1;">
                            <label for="prices[${cartype.slug}][]" style="font-weight: bold; color: #333;">Price for ${cartype.title}</label>
                            <input type="number" value="${cartype.amount}" name="prices[${cartype.slug}][]" class="form-control" placeholder="Enter price" required style="background-color: #fff; border: 1px solid #ccc; color: #555;">
                        </div>
                    `;

                    // Append the new field to the car types section
                    carTypesSection.appendChild(newField);
                });

                // Append the new season container to the seasons container
                document.getElementById('seasons_container').appendChild(newSeasonContainer);

                // Add event listener for delete button
                newSeasonContainer.querySelector('.deleteSeasonBtn').addEventListener('click', function() {
                    newSeasonContainer.remove(); // Remove the season container when the delete button is clicked
                });
            })
            .catch(error => console.error('Error fetching car types:', error));
    });

    document.getElementById('seasonForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = {
            seasons: []
        };

        const seasonContainers = document.querySelectorAll('.season-container');
        seasonContainers.forEach(seasonContainer => {
            const seasonNameInput = seasonContainer.querySelector('input[name="season_name[]"]');
            const seasonStartDateInput = seasonContainer.querySelector('input[name="season_start_date[]"]');
            const seasonEndDateInput = seasonContainer.querySelector('input[name="season_end_date[]"]');

            if (seasonNameInput && seasonStartDateInput && seasonEndDateInput) {
                const seasonData = {
                    season_name: seasonNameInput.value,
                    season_start_date: seasonStartDateInput.value,
                    season_end_date: seasonEndDateInput.value,
                    prices: []
                };

                const carTypeFields = seasonContainer.querySelectorAll('.car-types-section .d-flex');
                carTypeFields.forEach(field => {
                    const carTypeSlug = field.getAttribute('data-cartype-slug');
                    const price = field.querySelector('input[type="number"]').value;
                    const carTypeTitle = field.querySelector('input[type="text"]').value;

                    // Include both car type title and price
                    seasonData.prices.push({
                        car_type_slug: carTypeSlug,
                        price: price,
                        car_type_title: carTypeTitle
                    });
                });

                formData.seasons.push(seasonData);
            }
        });

        fetch('{{ route('admin.peakseason.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            alert('Form submitted successfully!');
            window.location.reload(); // Refresh the page after successful submission
        })
        .catch(error => {
            console.error('Error submitting form:', error);
        });
    });


    $(document).on('change', '.toggleSeasonStatus', function () {
        let seasonId = $(this).data('id');
        let isEnabled = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: '{{ route('admin.peakseasonupdatestatus.store') }}', // Update this with your route
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF protection
                id: seasonId,
                enable: isEnabled
            },
            success: function (response) {
                if (response.success) {
                    alert('Season status updated successfully!');
                } else {
                    alert('Failed to update season status.');
                }
            },
            error: function () {
                alert('Error updating season status.');
            }
        });
    });


    $(document).on('click', '.deleteSeasonBtn2', function () {
        let seasonId = $(this).data('id');
        let confirmDelete = confirm("Are you sure you want to delete this season?");

        if (confirmDelete) {
            $.ajax({
                url: '{{ route('delete.season') }}', // Your route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF Token for security
                    id: seasonId
                },
                success: function (response) {
                    if (response.success) {
                        alert("Season deleted successfully!");
                        location.reload(); // Refresh the page to reflect changes
                    } else {
                        alert("Failed to delete the season.");
                    }
                },
                error: function () {
                    alert("Error deleting season.");
                }
            });
        }
    });


</script>


@endsection
