<?php

use function Livewire\Volt\{state};

//

?>

<x-app-layout>
    <div class="bg-white">
        <x-page-header name="Add a New Driver">
            <a href="{{ route('driver.index') }}">
                <x-primary-button>
                    {{__('Go Back')}}
                </x-primary-button>
            </a>
        </x-page-header>
        <div class="w-[848px] h-[664px] bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
            <form class="mt-4">
                <div class="text-black text-xl font-bold  tracking-tight">Driver Details</div>
                <div class="form-row mt-4">
                  <div class="col-md-4 mb-3">
                    <div class="form-group has-success">
                      <input type="text" class="form-control is-valid" id="validationServer01" placeholder="First name" value="Mark" required="">
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="form-group has-success">
                      <input type="text" class="form-control is-valid" id="validationServer02" placeholder="Last name" value="Otto" required="">
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="form-group has-danger">
                      <input type="text" class="form-control is-invalid" id="validationServerUsername" placeholder="Contact number" aria-describedby="inputGroupPrepend3" required="">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group has-danger">
                          <input type="text" class="form-control is-invalid" id="validationServerUsername" placeholder="Email" aria-describedby="inputGroupPrepend3" required="">
                        </div>
                      </div>
                </div>

                <div class="text-black text-xl font-bold  tracking-tight">license Details</div>

                <div class="form-row mt-4">
                  <div class="col-md-6 mb-3">
                    <div class="form-group has-danger">
                      <input type="text" class="form-control is-invalid" id="validationServer03" placeholder="License number" required="">
                      <div class="invalid-feedback">
                        Please provide a valid city.
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="form-group has-danger">
                      <input type="date" class="form-control is-invalid" id="validationServer05" placeholder="Expiry date" required="">
                      <div class="invalid-feedback">
                        Please provide a valid zip.
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row mt-4">
                    <div class="col-md-6 mb-3">
                      <div class="form-group has-danger">
                        <input type="file" class="form-control is-invalid" id="validationServer03" placeholder="License number" required="">
                        <div class="invalid-feedback">
                          Please provide a valid city.
                        </div>
                      </div>
                    </div>
                  </div>
                <x-primary-button>
                    {{__('Continue')}}
                </x-primary-button>
              </form>
        </div>
    </div>

</x-app-layout>
