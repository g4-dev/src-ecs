const path = require('path')

// TODO: Modulable test conf
module.exports = (space) => {
  console.log(space)
  return {
    rootDir: path.resolve(__dirname),
    runner: 'jest-runner-tsc',
    displayName: 'tsc',
    //moduleFileExtensions: ['js', 'ts'],
    //testMatch: ['<rootDir>/**/test/*.ts'],
    moduleNameMapper: {
      '^@/(.*)$': '<rootDir>/$1'
    },
    "testRegex": "**/test/.*.{js,ts}$",
    transform: {
      "\\.(ts)$": "<rootDir>/node_modules/ts-jest/preprocessor.js",
    },
    testPathIgnorePatterns: [
      '<rootDir>/test/e2e'
    ],
    setupFiles: ['<rootDir>/assets/jestEntry${space}.js'],
    mapCoverage: true,
    coverageDirectory: '<rootDir>',
    collectCoverageFrom: [
      '/**/*.{js,ts}',
      '!/assets/**/app.js',
      '!**/node_modules/**'
    ]
  }
}