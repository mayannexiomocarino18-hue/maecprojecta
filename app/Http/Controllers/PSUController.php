<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PSUController extends Controller
{
    //Part 1:
    function welcome($welcome = "May Anne Carino") {
    return "Welcome, " .$welcome;
    }

    function mission() {
    return "<h1> MISSION <h1/>
    <br> 
    The Pangasinan State University shall provide a human-centric, resilient and sustainable <br> 
    academic environment to produce dynamic, responsive and future-ready individuals capable of <br> 
    meeting the requirements of the local and global communities and industries." .date("y,m,d");
    }

    function vision() {
    return "<h1> VISION <h1/>
    <br>
    To be a leading industry-driven State University in the <br> 
    ASEAN region by 2030." .date("y,m,d");
    }

    function EOMSPolicy() {
    return "<h1> EOMS POLICY <h1/>
    <br>
    The Pangasinan State University shall be recognized as an ASEAN premier state university <br> 
    that provides quality education and satisfactory service delivery through instruction, research, <br> 
    extension and production.
    <br>
    We commit our expertise and resources to produce professionals who meet the expectations <br> 
    of the industry and other interested parties in the national and international community.
    <br>
    We shall continuously improve our operations through systems and process innovations guided <br> 
    by ethical, intellectual property and technology transfer standards in response to the changing <br>
    educational, scientific and technological developments for social responsiveness and <br> 
    in support of the institution's strategic direction." .date("y,m,d");
    }

    //Part 2:
    function student($name, $course) {
    return "Student: " .$name. " | Course: " .$course;
    }

}
