@api
Feature: Section Landing Content type
  As a visitor
  I want to see all the action links related to a subtopic
  So that I can do something.

  Scenario: The subtopic banner has correct markup.
    Given I am logged in as a user with the "administrator" role
    When I am viewing a "subtopic" content:
    | title                  | Nature & Outdoor Activities                                                            |
    | parent                 | State Parks & Recreation                                                               |
    | field_lede             | Outdoor Lede                                                                           |
    | field_description      | Outdoor description                                                                    |
    | field_agency_links     | MassParks - http://www.google.com, Department of Fish and Game - http://www.google.com |
    | status                 | 1                                                                                      |
    Given "action" content:
    | title                        | field_action_parent          |
    | Find a State Park            | Nature & Outdoor Activities  |
    | Get a State Park Pass        | Nature & Outdoor Activities  |
    | Reserve a Campsite           | Nature & Outdoor Activities  |
    | Find Scenic Viewing Areas    | Nature & Outdoor Activities  |
    | Download a Trail Map         | Nature & Outdoor Activities  |
    | Find Horseback Riding Trails | Nature & Outdoor Activities  |
    When I am at "admin/content"
    And I follow "Nature & Outdoor Activities"
    And I follow "Edit draft"
    And I fill in "edit-field-featured-content-target-id" with "Find A State Park"
    And I press "Save and Create New Draft"
    Then I see the subtopic page markup
    Then I see the text "Nature & Outdoor Activities"
    And I see the text "Outdoor Lede"
    And I see the text "Outdoor description"
    And I should see the link "Find a State Park" in the "subtopic_featured_actions" region
    And I should see the link "Get a State Park Pass" in the "subtopic_all_actions" region
    And I should not see the link "Find a State Park" in the "subtopic_all_actions" region
    And I should see the link "MassParks"
    And I should see the link "Department of Fish and Game"