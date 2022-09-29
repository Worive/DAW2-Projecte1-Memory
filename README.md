# Project 1: Memory
School project about making a memory game in JavaScript and PHP.

## Getting Started

### Requirements

- PHP 8.1+
- Web environment

### Instructions

Normal web page setup, just keep in mind you **must** set the `public` folder as the **root of the web page**.

### Configuration

You can configure the sub folder in `/config/config.php`. Example:****

## Code Structure

| File            | Description                                                                                               |
|-----------------|-----------------------------------------------------------------------------------------------------------|
| `form.js`       | Contains the interaction code for the form.                                                               |
| `memory.js`     | Game logic and interaction.                                                                               |
| `background.js` | Generates a background made out of emojis.                                                                |
| `confetti.js`   | Generates confetti on the screen. ([@mathusummut](https://www.cssscript.com/confetti-falling-animation/)) |

### Memory.js

Divided in 3 parts:

- **Utils:** Contains all the utility functions.
- **Game:** Contains the game logic.
- **DOM:** Contains the DOM manipulation functions.