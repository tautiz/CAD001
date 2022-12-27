<?php

$people = [
    ['name' => 'Jonas', 'age' => 35, 'profession' => 'dizaineris'],
    ['name' => 'Petras', 'age' => 40, 'profession' => 'mokytojas'],
    ['name' => 'Ona', 'age' => 25, 'profession' => 'studentė'],
    ['name' => 'Marija', 'age' => 22, 'profession' => 'studentė'],
    ['name' => 'Tomas', 'age' => 33, 'profession' => 'inžinierius'],
];

function filterPeople(array $people, int $age_from, bool $remove_students): array {
    $filtered_people = [];
    foreach ($people as $person) {
        if ($person['age'] >= $age_from && (!$remove_students || $person['profession'] != 'studentas' && $person['profession'] != 'studentė')) {
            $filtered_people[] = $person;
        }
    }
    return $filtered_people;
}

function displayPeopleTable($people): string {
    $output = "<table class='table'>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Vardas</th>
                        <th scope='col'>Amžius</th>
                        <th scope='col'>Profesija</th>
                    </tr>";
    foreach ($people as $key => $person) {
        $output .= "<tr scope='row'>
                        <td>$key</td>
                        <td>" . $person['name'] . "</td>
                        <td>" . $person['age'] . "</td>
                        <td>" . $person['profession'] . "</td>
                    </tr>";
    }
    $output .= "</table>";

    return $output;
}

// Filtravimo forma
$output = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<form action="assin.php" method="post" class="form-control">
<label for="age_from">Amžius nuo:</label>
<input type="number" name="age_from" id="age_from" class="form-control">
<button type="submit" class="btn btn-primary">Filtruoti</button>
<button type="submit" class="btn btn-secondary" name="remove_students" value="true">Išimti studentus</button>
</form>';

// Jeigu yra filtravimo formos duomenys, atvaizduojame lentelę
if (isset($_POST['age_from']) || isset($_POST['remove_students'])) {
    $age_from = (int)$_POST['age_from'] ?? 0;
    $remove_students = isset($_POST['remove_students']);
    $filtered_people = filterPeople($people, $age_from, $remove_students);
    $output .= displayPeopleTable($filtered_people);
} else {
    $output .= displayPeopleTable($people);
}

echo $output;
