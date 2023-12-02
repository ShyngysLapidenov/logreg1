<?php
session_start();

include("connection.php");
include("functinos.php");

$user_data = check_login($con);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formscss.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kenia&family=Noto+Sans+JP&family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <title>Registration and Login forms</title>

    <script>
        const container = document.querySelector(".container");
const headingSpan2 = document.querySelector(".heading-span-2");
const form = document.querySelector("form");


document.querySelector(".signup-btn").addEventListener('click',() => {
    container.classList.add("change");
    setTimeout(()=>{
    headingSpan2.textContent = ' Up';
    }, 200)
    form.className = 'form sign-up';
    clearForm();
});

document.querySelector(".signin-btn").addEventListener('click', () =>{
    container.classList.remove("change");
    setTimeout(()=>{
    headingSpan2.textContent = ' In';
    }, 200)
    form.className = 'form sign-in';
    clearForm();
});

const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');

const error = (input, message) =>{
    const inputWrapper = input.parentElement;
    inputWrapper.className = "form-input-wrapper error"
    inputWrapper.querySelector('.message').textContent = message;
}

const success = (input) => {
    const inputWrapper = input.parentElement;
    inputWrapper.className = "form-input-wrapper success";
}

const checkRequiredFields = (inputArr) => {
    inputArr.forEach((input) => {
        if(input.value.trim() === ""){
            if(input.id === password2){
                error(input, 'Password confirmation is required')
            }
            else{
                error(input, `${input.id} is required`);
            }
        }
        else{
            success(input);
        }
    })
}


const clearForm = () => {
    document.querySelectorAll('.form-input-wrapper').forEach((item) => {
        item.className = 'form-input-wrapper';
    });
    form.reset();
};

const checkLength = (input, min, max) => {
    if(input.value.length < min){
        error(input, `${input.id} must be at least ${min} characters`);
    }
    else if(input.value.length > max){
        error(input, `${input.id} must be less than ${max} characters`);
    }
    else{
        success(input);
    }
    
};

const passwordsMatch = (input1, input2) => {
    let savedpass;
    if(input1.value !== input2.value) {
        error(input2, 'Passwords do not match')
    }else if(input2.value === ''){
        error(input2, 'Confirmation is required')
    }
    else if(input1.value == input2.value){
        success(input2);
        savedpass == input2;
    }
};

const checkEmail = (input) => {
    const Regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if(Regex.test(input.value.trim())){
        success(input);
    }
    else{
        error(input, "Email is not valid");
    }
};


form.addEventListener('submit', (e) => {
    e.preventDefault(); 
    if(form.classList[1] === 'sign-up'){
        checkRequiredFields([username, email, password, password2])
        checkLength(username, 2, 15);
        checkLength(password, 5, 25);
        passwordsMatch(password, password2);
        checkEmail(email);
    }
    else{
        checkRequiredFields([email, password]);
        checkEmail(email);
    }
});
    </script>
</head>
<body>   
    <style type="text/css">
        body {
  /* background-color: #c5fad5;
  background: -webkit-linear-gradient(to right, #aa96da, #c5fad5, #ffffd2);
  background: linear-gradient(to right, #aa96da, #c5fad5, #ffffd2); */
  width: 100%;
  height: 100vh;
 /* display: flex; 
  align-items: center;
  justify-content: center; */
  font-size: 16px;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  outline: none;
  font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
    "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}


.container{
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.heading{
    position: absolute;
    top: 5rem;
    font-size: 7rem;
    font-weight: 300;
    color: #f03535;
    letter-spacing: 1rem;
    text-shadow: .2rem .2rem .5rem #aaa;
}

.heading span{
    position: relative;
}

.heading-span-1{
    z-index: 10;
}

.heading-span-2::after{
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #fff;
    right: -100%;
    transition: right 0.6s;
}

.change .heading-span-2::after{
    right: 100%;
}

.buttons{
    position: absolute;
    top: 5rem;
    left: 5rem;
    display: flex;
    flex-direction: column;
}

.buttons button{
    width: 10rem;
    height: 4rem;
    font-size: 2rem;
    color: #f03535;
    border: none;
    border-radius: 5rem;
    letter-spacing: .1rem;
    box-shadow: .3rem .2rem .8rem #eee;
    margin: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.signin-btn{
    background-color: #e7e7e7;
}

.signup-btn{
    background-color: #fff;
}

.change .signup-btn{
    background-color: #e7e7e7;
}

.change .signin-btn{
    background-color: #fff;
}

.form-bg{
    position: absolute;
    width: 60rem;
    height: 60rem;
    box-shadow: 1.5rem 1.5rem 1.5rem #ddd;
    transform: rotate(45deg);
}

.form{
    display: flex;
    flex-direction: column;
    z-index: 100;
}

.form-input-wrapper{
    margin: 1.5rem 0;
    box-shadow: 0.5rem 0.5rem 0.5rem #eee;
    border-radius: 5rem;
    position: relative;
}

.form-input-wrapper:nth-child(1),
.form-input-wrapper:nth-child(4){
    visibility: hidden;
    opacity: 0;
    transition: all .3s;
}

.change .form-input-wrapper:nth-child(1),
.change .form-input-wrapper:nth-child(4){
    visibility: visible;
    opacity: 1;
    transition: all .3s .3s;
}

.success .form-input{
    border: 1rem solid #46e75b;
}

.form input{
    width: 50rem;
    height: 4rem;
    background-color: #fff;
    font-size: 1.7rem;
    padding: 0 2rem;
    letter-spacing: 0.2rem;
    border: none;
    border-radius: 5rem;
    box-shadow: 0.3rem 0.3rem 0.5rem #eee inset;
    color: #888;
}

.form input:focus{
    box-shadow: .5rem .5rem 1rem #eee inset;
}


.form-btn{
    box-shadow: 0.5rem 0.5rem 1rem #ddd;
    color: #f03535;
    cursor: pointer;
    margin: 2rem 0;
    letter-spacing: 0.2rem;
    font-weight: bold;
    position: relative;
    top: -6rem;
    transition: top .3s .3s, box-shadow 0.3s;
}

.change .form-btn{
    top: 1rem;
    transition: top .3s, box-shadow 0.3s;
}

.form-btn:hover{
    color: #f03535;
    transition: 0.3s ease;
    box-shadow: 0.8rem 0.5rem 2rem #eee inset;
}

.message{
    position: absolute;
    left: 2rem;
    font-size: 1.2rem;
    font-weight: 700;
    letter-spacing: .1rem;
    text-transform: uppercase;
    top: 5rem;
    color: #f55e53;
    visibility: hidden;
    opacity: 0;
}

.error .message{
    visibility: visible;
    opacity: 1;
}

    </style>    

    <div class="container">
        <h1 class="heading">
            <span class="heading-span-1">Sign</span><span class="heading-span-2"> In</span>
        </h1>
        <div class="buttons">
            <button class="signin-btn">Sign In</button>
            <button class="signup-btn">Sign Up</button>
        </div>
        <div class="form-bg"></div>
        <form class="form sign-in">
            <div class="form-input-wrapper">
                <input type="text" id="username" class="form-input" placeholder="Your Name" autocomplete="off">
                <p class="message">Error Message</p> 
            </div>
            <div class="form-input-wrapper">
                <input type="text" id="email" class="form-input" placeholder="Email Address" autocomplete="off">
                <p class="message">Error Message</p> 
            </div>
            <div class="form-input-wrapper">
                <input type="password" id="password" class="form-input" placeholder="Your Password" autocomplete="off">
                <p class="message">Error Message</p> 
            </div>
            <div class="form-input-wrapper">
                <input type="password" id="password2" class="form-input" placeholder="Confirm Password" autocomplete="off">
                <p class="message">Error Message</p> 
            </div>
            <input type="submit" value="Submit" class="form-btn">
        </form>
    </div>

    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script defer src="formsjs.js"></script>
</body>
