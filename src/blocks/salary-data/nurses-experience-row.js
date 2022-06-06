export const RenderNursesYearsExperienceRow = ( queryTable ) => {
	let row;

	// Nurses Group A, Steps A-M.
	if ( queryTable.includes( 'nurses-a-am' ) ) {
		row = (
			<>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th>0</th>
				<th></th>
				<th>1</th>
				<th></th>
				<th>2</th>
				<th></th>
				<th>3</th>
				<th>4</th>
				<th>5</th>
			</>
		);
	}

	// Nurses Group A, Steps N-U.
	if ( queryTable.includes( 'nurses-a-nu' ) ) {
		row = (
			<>
				<th>6</th>
				<th>7</th>
				<th>8</th>
				<th>12</th>
				<th>15</th>
				<th>18</th>
				<th>20</th>
				<th>26</th>
			</>
		);
	}

	// Nurses Group B, Steps A-M.
	if ( queryTable.includes( 'nurses-b-am' ) ) {
		row = (
			<>
				<th>0</th>
				<th></th>
				<th>1</th>
				<th></th>
				<th>2</th>
				<th></th>
				<th>3</th>
				<th></th>
				<th>4</th>
				<th></th>
				<th>5</th>
				<th>6</th>
				<th>7</th>
			</>
		);
	}

	// Nurses Group B, Steps N-U.
	if ( queryTable.includes( 'nurses-b-nu' ) ) {
		row = (
			<>
				<th>8</th>
				<th>9</th>
				<th>10</th>
				<th>12</th>
				<th>15</th>
				<th>18</th>
				<th>20</th>
				<th>26</th>
			</>
		);
	}

	return (
		<tr>
			<th>
				<abbr title="Years of experience">YRSx</abbr>
			</th>
			{ row }
		</tr>
	);
};
